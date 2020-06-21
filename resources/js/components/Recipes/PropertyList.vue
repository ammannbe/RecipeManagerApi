<template>
  <form
    @submit.prevent="submit"
    @change="$store.commit('form/errors/clear', { property: $event.target.name })"
  >
    <ul>
      <li v-if="!$env.DISABLE_COOKBOOKS">
        <span
          :class="{'can-edit': canEdit}"
          :title="title"
          @click="toggleEdit('cookbook_id')"
        >Kochbuch:</span>

        <select-field
          v-if="canEdit && isEditing == 'cookbook_id' && cookbooks.length"
          name="cookbook_id"
          icon="fas fa-layer-group"
          placeholder="Öffentlich"
          nullable
          :data="cookbooks"
        ></select-field>

        <span v-else-if="recipe.cookbook">{{ recipe.cookbook.name }}</span>
      </li>

      <li v-if="recipe.author">
        <span>Verfasser:</span>
        <span>{{ recipe.author.name }}</span>
      </li>

      <li v-if="recipe.category">
        <span
          :class="{'can-edit': canEdit}"
          :title="title"
          @click="toggleEdit('category_id')"
        >Kategorie:</span>

        <select-field
          v-if="canEdit && isEditing == 'category_id'"
          name="category_id"
          icon="fas fa-layer-group"
          required
          :data="categories"
        ></select-field>

        <span v-else>{{ recipe.category.name }}</span>
      </li>

      <li v-if="recipe.yield_amount">
        <span
          :class="{'can-edit': canEdit}"
          :title="title"
          @click="toggleEdit('yield_amount');"
        >Portionen:</span>

        <input-field
          v-if="canEdit && isEditing == 'yield_amount'"
          name="yield_amount"
          min="1"
          max="999"
          step="1"
          placeholder="Portionen eingeben..."
          icon="fas fa-sort-amount-up"
          type="number"
          @changed="updateYieldAmount(recipe.yield_amount)"
        ></input-field>

        <div v-else-if="recipe.yield_amount">
          <input
            v-model="yieldAmount"
            name="yield_amount"
            type="number"
            min="1"
            step="0.5"
            autofocus
            @keyup="updateYieldAmount(yieldAmount)"
          />
        </div>
        <span v-else>-</span>
      </li>

      <li v-if="recipe.complexity">
        <span
          :class="{'can-edit': canEdit}"
          :title="title"
          @click="toggleEdit('complexity')"
        >Schwierigkeitsgrad:</span>

        <select-field
          v-if="canEdit && isEditing == 'complexity'"
          name="complexity"
          icon="fas fa-signal"
          required
          :data="complexities"
        ></select-field>

        <span v-else>{{ recipe.complexity.name }}</span>
      </li>

      <li v-if="true">
        <span
          :class="{'can-edit': canEdit}"
          :title="title"
          @click="toggleEdit('preparation_time')"
        >Zubereitungszeit:</span>

        <input-field
          v-if="canEdit && isEditing == 'preparation_time'"
          name="preparation_time"
          icon="fas fa-clock"
          type="time"
        ></input-field>

        <span v-else-if="recipe.preparation_time">{{ recipe.preparation_time }}</span>
        <span v-else>-</span>
      </li>
    </ul>

    <div v-if="!$env.DISABLE_TAGS">
      <span :class="{'can-edit': canEdit}" :title="title" @click="toggleEdit('tags')">Tags:</span>

      <multiselect-field
        v-if="!$env.DISABLE_TAGS && canEdit && isEditing == 'tags'"
        name="tags"
        placeholder="Tags auswählen..."
        icon="fas fa-tags"
        :data="tags"
      ></multiselect-field>

      <router-link
        v-else-if="recipe.tags && recipe.tags.length"
        :key="tag.id"
        v-for="tag in recipe.tags"
        class="tag is-success"
        tag="a"
        :to="{ name: 'home', query: { 'search[tag]': tag.slug } }"
      >{{ tag.name }}</router-link>
      <span v-else>
        <span>-</span>
      </span>
    </div>

    <br />

    <submit-button
      v-if="canEdit && isEditing"
      :can-cancel="true"
      @cancel="isEditing = null"
    >Speichern</submit-button>
  </form>
</template>

<script>
import Recipes from "../../modules/ApiClient/Recipes";
import { mapState } from "vuex";

export default {
  props: ["canEdit"],
  data() {
    return {
      yieldAmount: null,
      isEditing: null
    };
  },
  computed: {
    ...mapState({
      tags: state => state.tag.tags,
      categories: state => state.category.categories,
      cookbooks: state => state.cookbook.cookbooks.data,
      complexities: state => state.recipe.complexities,
      recipe(state) {
        let recipe = state.recipe.recipe;

        if (!Object.keys(recipe).length) {
          return recipe;
        }

        if (!this.yieldAmount) {
          this.updateYieldAmount(recipe.yield_amount);
          this.yieldAmount = null;
        }

        Object.keys(recipe).forEach(property =>
          this.$store.dispatch("form/update", {
            property,
            value: recipe[property]
          })
        );
        this.$store.dispatch("form/update", {
          property: "complexity",
          value: recipe.complexity.id
        });
        this.$store.dispatch("form/update", {
          property: "tags",
          value: recipe.tags.map(tag => tag.id)
        });

        return recipe;
      }
    }),
    title() {
      if (this.canEdit) {
        return "Klicken zum Bearbeiten";
      }
      return "";
    }
  },
  created() {
    if (!this.$env.DISABLE_COOKBOOKS && this.$Laravel.isLoggedIn) {
      this.$store.dispatch("cookbook/index", { limit: 1000 });
    }
    this.$store.dispatch("category/index");
    if (!this.$env.DISABLE_TAGS) {
      this.$store.dispatch("tag/index");
    }
  },
  mounted() {
    const routeYieldAmount = this.$route.query.yield_amount;
    if (routeYieldAmount) {
      this.yieldAmount = routeYieldAmount;
      setTimeout(() => {
        this.updateYieldAmount(routeYieldAmount);
      }, 500);
    } else {
      setTimeout(() => {
        this.updateYieldAmount(this.recipe.yield_amount);
      }, 500);
    }
  },
  methods: {
    updateYieldAmount(yieldAmount) {
      this.yieldAmount = yieldAmount;
      if (yieldAmount != this.recipe.yield_amount) {
        let yield_amount = yieldAmount;
        this.$router.push({ query: { ...this.$route.query, yield_amount } });
      } else {
        let query = Object.assign({}, this.$route.query);
        delete query.yield_amount;
        this.$router.push({ query });
      }
      this.$emit("multiply", (1 / this.recipe.yield_amount) * yieldAmount);
    },
    toggleEdit(field) {
      if (field == "yield_amount") {
        this.updateYieldAmount(this.yieldAmount);
      }
      if (!this.canEdit) {
        return;
      }
      if (this.isEditing === field) {
        field = null;
      } else {
        this.$store.commit("form/set", { data: { [field]: null } });
      }
      this.isEditing = field;
    },
    submit() {
      if (!this.canEdit) {
        return;
      }
      let id = this.recipe.id;
      let property = this.isEditing;
      let value = this.form[property];

      this.$store
        .dispatch("form/submit", {
          func: () => new Recipes().update(this.recipe.id, property, value)
        })
        .then(() => {
          this.isEditing = null;
          this.$store.dispatch("recipe/show", { id });
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.can-edit {
  cursor: pointer;
}
li {
  display: flex;
  align-items: flex-start;

  > *:first-child {
    margin-right: 3px;
  }

  > div {
    display: inline-flex;
    align-items: center;
    margin: 3px;

    > input[name="yield_amount"] {
      margin-right: 3px;
    }
  }
}
.tag {
  margin-right: 3px;
}
</style>
