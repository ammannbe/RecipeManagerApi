<template>
  <div>
    <div class="headline">
      <edit-mode-switch v-if="recipe.can_edit" @toggle="canEdit = $event"></edit-mode-switch>
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

      <div
        class="ingredients"
        v-if="(groupedIngredients && Object.keys(groupedIngredients).length) || showAddForm"
      >
        <div :key="key" v-for="(ingredients, key) in groupedIngredients">
          <h4
            class="title is-4"
            v-if="ingredients[0].ingredient_group"
          >{{ ingredients[0].ingredient_group.name }}</h4>

          <h2
            v-else
            class="title is-4"
            :class="{'add-ingredient-form': canEdit, 'show': !showAddForm, 'cancel': showAddForm}"
            :title="title"
            @click="showIngredientAddForm(!showAddForm)"
          >Zutaten</h2>
          <ingredient-list
            :show-add-form="showAddForm && key == 0"
            :recipeId="id"
            :ingredients="ingredients"
            :can-edit="canEdit"
            :multiplier="multiplier"
            :first-level-list="true"
            @created="fetchIngredients()"
            @updated="fetchIngredients()"
            @removed="fetchIngredients()"
            @cancelAdd="showIngredientAddForm(false)"
            @position="position(key, $event.id, $event.position)"
          ></ingredient-list>
        </div>
      </div>
      <div v-else>
        <h2
          class="title is-4"
          :class="{'add-ingredient-form': canEdit, 'show': !showAddForm, 'cancel': showAddForm}"
          :title="title"
          @click="showIngredientAddForm(!showAddForm)"
        >Zutaten</h2>
        <span>Keine Zutaten vorhanden!</span>
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
      groupedIngredients: null,
      multiplier: 1,
      canEdit: false,
      showAddForm: false,
      title: ""
    };
  },
  beforeMount() {
    this.fetchRecipe();
    this.fetchIngredients();
  },
  mounted() {
    this.showIngredientAddForm(
      this.$route.query["add[ingredient]"] == "true" || false
    );
  },
  watch: {
    canEdit() {
      this.title = "";
      if (this.canEdit) {
        this.title = "Klicken zum Hinzufügen";
      }
    }
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
      this.groupedIngredients = await new Ingredients(true, this.id).index({
        grouped: 1
      });
      this.sortGroupedIngredients();
    },
    sortGroupedIngredients() {
      Object.keys(this.groupedIngredients).forEach(key => {
        this.groupedIngredients[key].sort((a, b) => a.position - b.position);
      });
    },
    position(groupId, ingredientId, position) {
      let index = this.groupedIngredients[groupId].findIndex(
        i => i.id === ingredientId
      );
      this.groupedIngredients[groupId][index].position = position;
      this.sortGroupedIngredients();
    },
    showIngredientAddForm(show = true) {
      if (!this.canEdit) {
        return;
      }
      this.showAddForm = show;

      if (show) {
        let add = { "add[ingredient]": true };
        this.$router.push({ query: { ...this.$route.query, ...add } });
      } else {
        let query = Object.assign({}, this.$route.query);
        delete query["add[ingredient]"];
        this.$router.push({ query });
      }
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
}

div.ingredients {
  display: flex;
  justify-content: flex-end;
  flex-direction: row-reverse;
  flex-wrap: wrap-reverse;

  .title.is-4 {
    margin-top: 20px;
  }

  > div {
    margin-right: 15px;
    border-right: 1px dotted black;
    padding-right: 35px;
  }
}

.add-ingredient-form {
  &.show {
    cursor: copy;
  }
  &.cancel {
    cursor: no-drop;
  }
}
</style>
