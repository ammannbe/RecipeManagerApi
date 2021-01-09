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
        <recipe-photo
          class="column is-one-fifth"
          :urls="recipe.photos.map(p => p.url)"
          :alt="recipe.name"
        />
        <property-list @update="update" @multiply="multiplier = $event" />
      </div>

      <hr />

      <ingredient-list-container :id="id" :multiplier="multiplier" />

      <hr />

      <instructions @update="update" />

      <hr />

      <div v-if="false" class="ratings">
        <h2 class="title is-4">{{ $t("Ratings") }}</h2>
        <!-- TODO: -->
        <rating-card-list :id="id" />
      </div>
    </div>

    <div class="edit-buttons" v-if="this.loggedIn && recipe.can_edit">
      <button
        class="button is-rounded is-danger"
        v-if="editmode.enabled"
        @click="remove"
      >
        Löschen
      </button>
      <button
        class="button is-rounded"
        v-if="editmode.enabled"
        @click="
          $store.dispatch('recipe/editmode/edit', {
            editing: !editmode.editing
          })
        "
      >
        Bearbeiten
      </button>
      <button
        @click="
          $store.dispatch('recipe/editmode/enable', {
            enable: !editmode.enabled
          })
        "
        class="button is-rounded is-primary enable"
        :class="{ 'is-open': editmode.enabled }"
      >
        <i v-if="editmode.enabled" class="fas fa-times"></i>
        <i v-else class="fas fa-bars"></i>
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
  metaInfo() {
    const meta = [];
    this.$env.LOCALES.forEach(locale =>
      meta.push({ property: "og:locale:alternate", content: locale })
    );
    if (this.recipe.photos && this.recipe.photos.length) {
      meta.push({
        property: "og:image",
        content: this.recipe.photos[0].url + "?thumbnail"
      });
    }
    let author = {};
    if (this.recipe.author) {
      author = this.recipe.author;
    }
    let category = {};
    if (this.recipe.category) {
      category = this.recipe.category;
    }

    return {
      title: this.recipe.name,
      meta: [
        {
          name: "description",
          content: this.$t(
            `${this.recipe.name} from ${author.name} in category ${category.name}`
          )
        },
        { name: "robots", content: "index,follow" },
        { property: "og:type", content: "website" },
        { property: "og:locale", content: this.$env.LOCALE },
        { property: "og:site_name", content: this.recipe.name },
        {
          property: "og:title",
          content: `${this.recipe.name} - ${category.name}`
        },
        {
          property: "og:description",
          content: this.$t(
            `${this.recipe.name} from ${author.name} in category ${category.name}`
          )
        },
        { property: "og:url", content: window.location.href },
        ...meta
      ]
    };
  },
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
  padding: 0px 10px 20px 10px;
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
    padding-top: 11px;
    padding-bottom: 11px;
    padding-left: 18px;
    padding-right: 18px;
    font-size: 23px;

    &.is-open {
      > i {
        padding-top: 13px;
        padding-bottom: 13px;
        padding-right: 2px;
        padding-left: 2px;
      }
    }
  }
}
</style>
