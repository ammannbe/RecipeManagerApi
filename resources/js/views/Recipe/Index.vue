<template>
  <div v-if="loaded">
    <div class="headline">
      <div></div>
      <social-sharing
        :url="url"
        :name="recipe.name"
        :author="recipe.author.name"
        :category="recipe.category.name"
      ></social-sharing>
    </div>

    <recipe-title @update="update" />

    <div class="container">
      <breadcrumb-trail :category="recipe.category" />
      <div class="meta columns">
        <recipe-photo class="column is-one-fifth" :urls="recipe.photo_urls" :alt="recipe.name" />
        <property-list @update="update" @multiply="multiplier = $event" />
      </div>

      <hr />

      <ingredient-list-container :id="id" :multiplier="multiplier" />

      <hr />

      <instructions @update="update" />

      <hr />

      <div v-if="false" class="ratings">
        <h2 class="title is-4">{{ $t('Ratings') }}</h2>
        <!-- TODO: -->
        <rating-card-list :id="id" />
      </div>
    </div>

    <div class="edit-buttons" v-if="this.loggedIn && recipe.can_edit">
      <button class="button is-rounded is-danger" v-if="editmode.enabled" @click="remove">Löschen</button>
      <button
        class="button is-rounded"
        v-if="editmode.enabled"
        @click="$store.dispatch('recipe/editmode/edit', { editing: !editmode.editing })"
      >Bearbeiten</button>
      <button
        @click="$store.dispatch('recipe/editmode/enable', { enable: !editmode.enabled })"
        class="button is-rounded is-primary enable"
      >
        <i class="fas fa-edit"></i>
      </button>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import Recipes from "../../modules/ApiClient/Recipes";
import Ingredients from "../../modules/ApiClient/Ingredients";
import SocialSharing from "./SocialSharing";
import RecipeTitle from "./RecipeTitle";
import RecipePhoto from "./RecipePhoto";
import PropertyList from "./PropertyList/PropertyList";
import IngredientListContainer from "./Ingredient/IngredientListContainer";
import Instructions from "./Instructions";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "recipe/form/getFormFields",
  mutationType: "recipe/form/updateFormFields"
});

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
      multiplier: 1,
      loaded: false
    };
  },
  computed: {
    ...mapState({
      recipe: state => state.recipe.data,
      editmode: state => state.recipe.editmode.data,
      form: state => state.recipe.form.data
    }),
    ...mapGetters({
      loggedIn: "user/loggedIn"
    }),
    ...mapFields([
      "cookbook_id",
      "tags",
      "category_id",
      "yield_amount",
      "complexity",
      "preparation_time",
      "name",
      "instructions"
    ]),
    url() {
      const name = "recipes";
      const params = { id: this.recipe.id, slug: this.recipe.slug };
      return this.$env.APP_URL + this.$router.resolve({ name, params }).href;
    }
  },
  created() {
    setTimeout(() => {
      this.load().then(() => {
        if (!this.recipe.can_edit) {
          this.$store.dispatch("recipe/editmode/enable", { enable: false });
        }
      });
    }, 500);
  },
  methods: {
    async load() {
      (this.loaded = false),
        await this.$store.dispatch("recipe/show", { id: this.id });

      if (this.loggedIn) {
        this.$store.dispatch("categories/index", {});
      }

      if (!this.$env.DISABLE_COOKBOOKS && this.loggedIn) {
        this.$store.dispatch("cookbooks/index", { limit: 1000 });
      }

      if (!this.$env.DISABLE_TAGS && this.loggedIn) {
        this.$store.dispatch("tags/index", {});
      }

      this.initForm();

      this.loaded = true;
    },
    initForm() {
      const recipe = this.recipe;

      this.cookbook_id = null;
      if (!this.$env.DISABLE_COOKBOOKS && this.loggedIn) {
        this.cookbook_id = recipe.cookbook_id;
      }
      this.tags = [];
      if (!this.$env.DISABLE_TAGS && this.loggedIn) {
        this.tags = recipe.tags.map(tag => tag.id);
      }
      this.category_id = recipe.category_id;
      this.yield_amount = recipe.yield_amount;
      this.complexity = recipe.complexity.id;
      this.preparation_time = recipe.preparation_time;
      this.name = recipe.name;
      this.instructions = recipe.instructions;
    },
    async update() {
      await this.$store.dispatch("recipe/update", {
        id: this.recipe.id,
        data: this.form
      });
      await this.$store.dispatch("recipe/editmode/edit", { editing: false });
    },
    remove() {
      this.$buefy.dialog.confirm({
        message: this.$t("Delete recipe?"),
        cancelText: this.$t("Cancel"),

        onConfirm: async () => {
          await this.$store.dispatch("recipe/remove", { id: this.recipe.id });
          this.$router.push({ name: "home" });
        }
      });
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

.delete-button {
  margin-top: 7px;
}

.edit-buttons {
  position: fixed;
  right: 5%;
  bottom: 10%;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  z-index: 99999;

  > button {
    margin-top: 5px;
  }

  > .enable {
    padding-top: 10px;
    padding-bottom: 11px;
    padding-left: 17px;
    padding-right: 13px;
    font-size: 23px;
  }
}
</style>
