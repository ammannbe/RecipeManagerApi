<template>
  <div v-if="loaded">
    <div class="headline">
      <edit-mode-switch v-model="canEdit" :condition="recipe.can_edit"></edit-mode-switch>
      <social-sharing
        :url="$env.APP_URL + $router.resolve({ name: 'recipes', params: { id: recipe.id, slug: recipe.slug } }).href"
        :name="recipe.name"
        :author="recipe.author.name"
        :category="recipe.category.name"
      ></social-sharing>
    </div>

    <recipe-title @update="update"></recipe-title>

    <div class="container">
      <breadcrumb-trail :category="recipe.category" />
      <div class="meta columns">
        <recipe-photo class="column is-one-fifth" :urls="recipe.photo_urls" :alt="recipe.name"></recipe-photo>
        <property-list @update="update" @multiply="multiplier = $event"></property-list>
      </div>

      <hr />

      <ingredient-list-container :id="id" :multiplier="multiplier"></ingredient-list-container>

      <hr />

      <instructions @update="update"></instructions>

      <hr />

      <div v-if="false" class="ratings">
        <h2 class="title is-4">{{ $t('Ratings') }}</h2>
        <!-- TODO: -->
        <rating-card-list :id="id"></rating-card-list>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import Recipes from "../../modules/ApiClient/Recipes";
import Ingredients from "../../modules/ApiClient/Ingredients";
import SocialSharing from "./SocialSharing";
import RecipeTitle from "./RecipeTitle";
import RecipePhoto from "./RecipePhoto";
import PropertyList from "./PropertyList/PropertyList";
import IngredientListContainer from "./Ingredient/IngredientListContainer";
import Instructions from './Instructions';

export default {
  components: {
    SocialSharing,
    RecipeTitle,
    RecipePhoto,
    PropertyList,
    IngredientListContainer,
    Instructions
  },
  props: ["id", "slug"],
  data() {
    return {
      multiplier: 1
    };
  },
  computed: {
    ...mapState({
      recipe: state => state.recipe.data,
      editmode: state => state.recipe.editmode.data,
      form: state => state.recipe.form.data
    }),
    canEdit: {
      get() {
        return this.editmode.enabled;
      },
      set(enable) {
        this.$store.commit("recipe/editmode/enable", { enable });
      }
    },
    loaded() {
      const loaded = Object.keys(this.recipe).length && this.form;
      this.$loading.open();

      if (loaded) {
        this.$loading.close();
      }

      return loaded;
    }
  },
  created() {
    this.load().then(() => {
      this.initForm();

      if (!this.recipe.can_edit) {
        this.$store.commit("recipe/editmode/enable", { enable: false });
      }
    });
  },
  methods: {
    async load() {
      await this.$store.dispatch("recipe/show", { id: this.id });

      if (this.editmode.enabled) {
        this.$store.dispatch("categories/index");
      }

      if (!this.$env.DISABLE_COOKBOOKS && this.editmode.enabled) {
        this.$store.dispatch("cookbooks/index", { limit: 1000 });
      }

      if (!this.$env.DISABLE_TAGS && this.editmode.enabled) {
        this.$store.dispatch("tags/index");
      }
    },
    initForm() {
      let data = {};
      data.cookbook_id = null;
      if (!this.$env.DISABLE_COOKBOOKS && this.editmode.enabled) {
        data.cookbook_id = this.recipe.cookbook_id;
      }
      data.tags = [];
      if (!this.$env.DISABLE_TAGS && this.editmode.enabled) {
        data.tags = this.recipe.tags.map(tag => tag.id);
      }

      this.$store.commit("recipe/form/set", {
        data: {
          category_id: this.recipe.category_id,
          yield_amount: this.recipe.yield_amount,
          complexity: this.recipe.complexity.id,
          preparation_time: this.recipe.preparation_time,
          name: this.recipe.name,
          instructions: this.recipe.instructions,
          ...data
        }
      });
    },
    async update() {
      await this.$store.dispatch("recipe/update", {
        id: this.recipe.id,
        data: this.form
      });
      await this.$store.commit("recipe/editmode/edit", { editing: false });
    }
  }
};
</script>

<style lang="scss" scoped>
.headline {
  display: flex;
  justify-content: space-between;
}

.meta {
  display: flex;
  flex-wrap: wrap;
  margin-top: 5px;
}
</style>
