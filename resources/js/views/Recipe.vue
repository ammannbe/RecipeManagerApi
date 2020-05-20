<template>
  <div>
    <div class="headline">
      <edit-mode-switch @toggle="canEdit = $event"></edit-mode-switch>
      <social-sharing :recipe="recipe"></social-sharing>
    </div>

    <recipe-title :can-edit="canEdit" :recipe="recipe" @update="fetchRecipe()"></recipe-title>

    <div class="container">
      <link-path-list v-if="recipe.id" :recipe="recipe"></link-path-list>
      <div class="meta">
        <recipe-photo :urls="recipe.photo_urls" :alt="recipe.name"></recipe-photo>
        <property-list
          @update="fetchRecipe()"
          :recipe="recipe"
          :can-edit="canEdit"
          @multiply="multiplier = $event"
        ></property-list>
      </div>

      <hr />

      <div class="ingredients">
        <ingredient-list
          :show-title="true"
          :recipeId="id"
          :ingredients="ingredients"
          :edit-mode="canEdit"
          :multiplier="multiplier"
          :first-level-list="true"
          @created="this.fetchIngredients()"
          @updated="this.fetchIngredients()"
          @removed="this.fetchIngredients()"
          @position="position($event.id, $event.position)"
        ></ingredient-list>
      </div>

      <hr />

      <instructions
        :recipe-id="recipe.id"
        :instructions="recipe.instructions"
        :can-edit="canEdit"
        @updated="fetchRecipe()"
      ></instructions>

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
import Recipes from "../modules/ApiClient/Recipes";
import Complexities from "../modules/ApiClient/Complexities";
import Ingredients from "../modules/ApiClient/Ingredients";

export default {
  props: ["id", "slug", "search"],
  data() {
    return {
      recipe: {
        author: {},
        cookbook: {},
        category: {},
        complexity: {},
        tags: [],
        photo_urls: []
      },
      ingredients: [],
      multiplier: 1,
      canEdit: false
    };
  },
  beforeMount() {
    this.fetchRecipe();
    this.fetchIngredients();
  },
  methods: {
    async fetchRecipe() {
      let recipe = await new Recipes().show(this.id);
      let complexities = await new Complexities().index();
      recipe.complexity = complexities.filter(
        complexity => complexity.id === recipe.complexity
      )[0];

      this.recipe = recipe;
    },
    async fetchIngredients() {
      this.ingredients = await new Ingredients(true, this.id).index();
      this.sortIngredients();
    },
    sortIngredients() {
      this.ingredients.sort((a, b) => a.position - b.position);
    },
    position(ingredientId, position) {
      let index = this.ingredients.findIndex(i => i.id === ingredientId);
      this.ingredients[index].position = position;
      this.sortIngredients();
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
}
</style>
