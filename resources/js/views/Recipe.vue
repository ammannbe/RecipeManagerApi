<template>
  <div v-if="recipe">
    <div class="headline">
      <edit-mode-switch :condition="recipe.can_edit"></edit-mode-switch>
      <social-sharing
        v-if="recipe.category && recipe.author"
        :url="$env.APP_URL + $router.resolve({ name: 'recipes', params: { id: recipe.id, slug: recipe.slug } }).href"
        :name="recipe.name"
        :author="recipe.author.name"
        :category="recipe.category.name"
      ></social-sharing>
    </div>

    <recipe-title
      :recipe-id="recipe.id"
      :recipe-name="recipe.name"
      :can-edit="canEdit"
      @update="$store.dispatch('recipe/show', { id })"
    ></recipe-title>

    <div class="container">
      <link-path-list v-if="recipe.category" :category="recipe.category"></link-path-list>
      <div class="meta">
        <recipe-photo :urls="recipe.photo_urls" :alt="recipe.name"></recipe-photo>
        <property-list :can-edit="canEdit" @multiply="multiplier = $event"></property-list>
      </div>

      <hr />

      <ingredient-list-container :id="id" :multiplier="multiplier"></ingredient-list-container>

      <hr />

      <instructions :can-edit="canEdit"></instructions>

      <hr />

      <div v-if="recipe.ratings" class="ratings">
        <h2 class="title is-4">Bewertungen</h2>
        <!-- TODO: -->
        <rating-card-list :id="id"></rating-card-list>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import Recipes from "../modules/ApiClient/Recipes";
import Ingredients from "../modules/ApiClient/Ingredients";

export default {
  props: ["id", "slug", "search"],
  data() {
    return {
      multiplier: 1
    };
  },
  computed: {
    ...mapState({
      canEdit: state => state.editmode.enabled,
      recipe: state => state.recipe.recipe
    })
  },
  created() {
    let id = this.id;
    this.$store.dispatch("recipe/show", { id });
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
}
</style>
