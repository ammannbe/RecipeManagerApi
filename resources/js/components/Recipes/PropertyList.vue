<template>
  <form @submit.prevent="submit" @change="form.errors.clear($event.target.name)">
    <ul>
      <li v-if="!$env.DISABLE_COOKBOOKS">
        <span
          :class="{'can-edit': canEdit}"
          :title="title"
          @click="toggleEdit('cookbook_id')"
        >Cookbook:</span>
        <div @click.stop v-if="canEdit && currentEdit == 'cookbook_id' && cookbooks.length">
          <input-field name="cookbook_id" :errors="form.errors.get('cookbook_id')">
            <template v-slot:input>
              <div class="select">
                <select v-model="form._data.cookbook_id" name="cookbook_id">
                  <option :value="null">Öffentlich</option>
                  <option
                    :key="cookbook.id"
                    v-for="cookbook in cookbooks"
                    :value="cookbook.id"
                  >{{ cookbook.name }}</option>
                </select>
              </div>
            </template>
            <template v-slot:icon>
              <i class="fas fa-layer-group"></i>
            </template>
          </input-field>
        </div>
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
        <div @click.stop v-if="canEdit && currentEdit == 'category_id'">
          <input-field name="category_id" required :errors="form.errors.get('category_id')">
            <template v-slot:input>
              <div class="select">
                <select v-model="form._data.category_id" name="category_id" required>
                  <option
                    :key="category.id"
                    v-for="category in categories"
                    :value="category.id"
                  >{{ category.name }}</option>
                </select>
              </div>
            </template>
            <template v-slot:icon>
              <i class="fas fa-layer-group"></i>
            </template>
          </input-field>
        </div>
        <span v-else>{{ recipe.category.name }}</span>
      </li>

      <li v-if="recipe.yield_amount">
        <span
          :class="{'can-edit': canEdit}"
          :title="title"
          @click="toggleEdit('yield_amount');"
        >Portionen:</span>
        <div @click.stop v-if="canEdit && currentEdit == 'yield_amount'">
          <input-field name="yield_amount" :errors="form.errors.get('yield_amount')">
            <template v-slot:input>
              <input
                v-model="form._data.yield_amount"
                name="yield_amount"
                type="number"
                min="1"
                step="0.5"
                autofocus
                placeholder="Portionen eingeben..."
                @keyup="updateYieldAmount(recipe.yield_amount)"
              />
            </template>
          </input-field>
        </div>
        <input
          v-else-if="recipe.yield_amount"
          v-model="yieldAmount"
          name="yield_amount"
          type="number"
          min="1"
          step="0.5"
          autofocus
          @keyup="updateYieldAmount(yieldAmount)"
        />
        <span v-else>-</span>
      </li>

      <li v-if="recipe.complexity">
        <span
          :class="{'can-edit': canEdit}"
          :title="title"
          @click="toggleEdit('complexity')"
        >Schwierigkeitsgrad:</span>
        <div @click.stop v-if="canEdit && currentEdit == 'complexity'">
          <input-field name="complexity" :errors="form.errors.get('complexity')">
            <template v-slot:input>
              <div class="select">
                <select v-model="form._data.complexity" name="complexity">
                  <option
                    :key="complexity.id"
                    v-for="complexity in complexities"
                    :value="complexity.id"
                  >{{ complexity.name }}</option>
                </select>
              </div>
            </template>
            <template v-slot:icon>
              <i class="fas fa-signal"></i>
            </template>
          </input-field>
        </div>
        <span v-else>{{ recipe.complexity.name }}</span>
      </li>

      <li v-if="true">
        <span
          :class="{'can-edit': canEdit}"
          :title="title"
          @click="toggleEdit('preparation_time')"
        >Zubereitungszeit:</span>
        <div @click.stop v-if="canEdit && currentEdit == 'preparation_time'">
          <input-field name="preparation_time" :errors="form.errors.get('preparation_time')">
            <template v-slot:input>
              <input
                v-model="form._data.preparation_time"
                name="preparation_time"
                class="input"
                type="time"
                placeholder="Zubereitungszeit eingeben..."
              />
            </template>
            <template v-slot:icon>
              <i class="fas fa-clock"></i>
            </template>
          </input-field>
        </div>
        <span v-else-if="recipe.preparation_time">{{ recipe.preparation_time.slice(0, -3) }}</span>
        <span v-else>-</span>
      </li>
    </ul>

    <div v-if="!$env.DISABLE_TAGS">
      <span :class="{'can-edit': canEdit}" :title="title" @click="toggleEdit('tags')">Tags:</span>
      <div @click.stop v-if="canEdit && currentEdit == 'tags'">
        <input-field name="tags" :errors="form.errors.get('tags')">
          <template v-slot:input>
            <multiselect
              v-model="tags.selected"
              :options="tags.data"
              :multiple="true"
              :close-on-select="false"
              track-by="id"
              placeholder="Tags eingeben..."
              label="name"
              select-label
              @select="multiselectAdd('tags', $event.id)"
              @remove="multiselectRemove('tags', $event.id)"
              @input="form.errors.clear('tags')"
            ></multiselect>
          </template>
        </input-field>
      </div>
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
        tags: null
      }),
      cookbooks: null,
      categories: null,
      complexities: null,
      yieldAmount: null,
      currentEdit: null,
      tags: {
        data: [],
        selected: null
      },
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
      this.form._data.category_id = this.recipe.category.id;
      this.form._data.yield_amount = this.recipe.yield_amount;
      if (this.recipe.cookbook_id) {
        this.form._data.cookbook_id = this.recipe.cookbook_id;
      }
      if (this.recipe.preparation_time) {
        this.form._data.preparation_time = this.recipe.preparation_time.slice(
          0,
          -3
        );
      }
      this.form._data.complexity = this.recipe.complexity.id;
      this.form._data.tags = this.recipe.tags.map(function(tag) {
        return tag["id"];
      });
      this.tags.selected = this.recipe.tags;
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
      if (!this.$env.DISABLE_COOKBOOKS && Auth.isValid()) {
        this.cookbooks = await new Cookbooks().index();
      }
      this.categories = await new Categories().index();
      if (!this.$env.DISABLE_TAGS) {
        this.tags.data = await new Tags().index();
      }
      this.complexities = await new Complexities().index();
      this.form._data.complexity = this.complexities[0].id;
    },
    multiselectAdd(key, value) {
      if (key === "tags") {
        this.form._data.tags.push(value);
        return;
      }
      this.form._data[key] = value;
    },
    multiselectRemove(key, value) {
      const index = this.form._data[key].indexOf(value);
      this.form._data[key].splice(index, 1);
    },
    submit() {
      let property = this.currentEdit;
      let value = this.form._data[property];

      this.form
        .submit(() => new Recipes().update(this.recipe.id, property, value))
        .then(() => this.updated());
    },
    updated() {
      let property = this.currentEdit;
      let value = this.form._data[property];

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
