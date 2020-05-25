<template>
  <form @submit.prevent="submit" @change="form.errors.clear($event.target.name)">
    <ul>
      <li v-if="!$env.DISABLE_COOKBOOKS">
        <span
          :class="{'can-edit': canEdit}"
          :title="title"
          @click="toggleEdit('cookbook_id')"
        >Kochbuch:</span>

        <select-field
          v-if="canEdit && currentEdit == 'cookbook_id' && cookbooks.length"
          :field="{ id: 'cookbook_id', icon: 'fas fa-layer-group', placeholder: 'Öffentlich', nullable: true }"
          :data="cookbooks"
          :form="form"
          @changed="form.set($event.id, $event.value)"
        ></select-field>

        <span v-else>{{ cookbookName }}</span>
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
          v-if="canEdit && currentEdit == 'category_id'"
          :field="{ id: 'category_id', required: true, icon: 'fas fa-layer-group' }"
          :data="categories"
          :form="form"
          @changed="form.set($event.id, $event.value)"
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
          v-if="canEdit && currentEdit == 'yield_amount'"
          :field="{
            id: 'yield_amount',
            min: '1',
            max: '999',
            step: '1',
            placeholder: 'Portionen eingeben...',
            icon: 'fas fa-sort-amount-up',
            type: 'number'
          }"
          :form="form"
          @changed="form.set($event.id, $event.value); updateYieldAmount(recipe.yield_amount)"
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
          <button
            @click.prevent="updateYieldAmount(recipe.yield_amount)"
            class="button is-black is-small"
          >
            <i class="fas fa-redo"></i>
          </button>
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
          v-if="canEdit && currentEdit == 'complexity'"
          :field="{ id: 'complexity', required: true, icon: 'fas fa-signal' }"
          :data="complexities"
          :form="form"
          @changed="form.set($event.id, $event.value)"
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
          v-if="canEdit && currentEdit == 'preparation_time'"
          :field="{ id: 'preparation_time', icon: 'fas fa-clock', type: 'time' }"
          :form="form"
          @changed="form.set($event.id, $event.value)"
        ></input-field>

        <span v-else-if="recipe.preparation_time">{{ recipe.preparation_time.slice(0, -3) }}</span>
        <span v-else>-</span>
      </li>
    </ul>

    <div v-if="!$env.DISABLE_TAGS">
      <span :class="{'can-edit': canEdit}" :title="title" @click="toggleEdit('tags')">Tags:</span>

      <multiselect-field
        v-if="!$env.DISABLE_TAGS && canEdit && currentEdit == 'tags'"
        :field="{ id: 'tags', placeholder: 'Tags auswählen...', icon: 'fas fa-tags' }"
        :data="tags"
        :form="form"
        @changed="form.set($event.id, $event.value)"
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

    <submit-button
      v-if="canEdit && currentEdit"
      :can-cancel="true"
      :disabled="form.errors.any()"
      @cancel="currentEdit = null"
    >Speichern</submit-button>
  </form>
</template>

<script>
import Form from "../../modules/Form";
import Recipes from "../../modules/ApiClient/Recipes";
import Cookbooks from "../../modules/ApiClient/Cookbooks";
import Categories from "../../modules/ApiClient/Categories";
import Tags from "../../modules/ApiClient/Tags";
import Complexities from "../../modules/ApiClient/Complexities";
import Auth from "../../modules/ApiClient/Auth";

export default {
  props: ["recipe", "canEdit"],
  data() {
    return {
      form: new Form({
        cookbook_id: null,
        category_id: null,
        complexity: null,
        preparation_time: null,
        yield_amount: null,
        tags: []
      }),
      cookbooks: null,
      categories: null,
      complexities: null,
      yieldAmount: null,
      currentEdit: null,
      tags: [],
      title: ""
    };
  },
  computed: {
    cookbookName() {
      if (this.recipe.cookbook) {
        return this.recipe.cookbook.name;
      } else {
        return "Öffentlich";
      }
    }
  },
  watch: {
    recipe() {
      if (!this.yieldAmount) {
        this.yieldAmount = this.recipe.yield_amount;
      }
      this.form.set("category_id", this.recipe.category.id);
      this.form.set("yield_amount", this.recipe.yield_amount);
      if (this.recipe.cookbook_id) {
        this.form.set("cookbook_id", this.recipe.cookbook_id);
      }
      if (this.recipe.preparation_time) {
        this.form.set(
          "preparation_time",
          this.recipe.preparation_time.slice(0, -3)
        );
      }
      this.form.set("complexity", this.recipe.complexity.id);
      this.form.set(
        "tags",
        this.recipe.tags.map(tag => tag.id)
      );
    },
    canEdit() {
      this.title = "";
      if (this.canEdit) {
        this.title = "Klicken zum Bearbeiten";
      }
    }
  },
  mounted() {
    if (this.$route.query.yield_amount) {
      this.yieldAmount = this.$route.query.yield_amount;
      setTimeout(() => {
        this.updateYieldAmount(this.$route.query.yield_amount);
      }, 500);
    }

    this.fetch();
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
      if (this.currentEdit === field) {
        field = null;
      }
      this.currentEdit = field;
    },
    async fetch() {
      if (!this.$env.DISABLE_COOKBOOKS && this.$Laravel.isLoggedIn) {
        this.cookbooks = await new Cookbooks().index();
      }
      this.categories = await new Categories().index();
      if (!this.$env.DISABLE_TAGS) {
        this.tags = await new Tags().index();
      }
      this.complexities = await new Complexities().index();
      this.form.set("complexity", this.complexities[0].id);
    },
    submit() {
      if (!this.canEdit) {
        return;
      }
      let property = this.currentEdit;
      let value = this.form.get(property);

      this.form
        .submit(() => new Recipes().update(this.recipe.id, property, value))
        .then(() => this.updated());
    },
    updated() {
      let property = this.currentEdit;
      let value = this.form.get(property);

      this.recipe[property] = value;
      this.currentEdit = null;

      this.$emit("update");
    }
  }
};
</script>

<style lang="scss">
.can-edit {
  cursor: pointer;
}
li {
  > div {
    display: inline-block;
    margin: 3px;
  }
}
.tag {
  margin-right: 3px;
}
</style>
