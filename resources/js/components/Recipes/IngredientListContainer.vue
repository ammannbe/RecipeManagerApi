<template>
  <div class="ingredients" v-if="ingredients.length">
    <div v-if="hasIngredientsWithoutGroup" :class="{'multiple-lists': ingredientGroups.length}">
      <h2
        class="title is-4"
        :class="{'add-ingredient-form': editmode.enabled, 'show': !showAddForm, 'cancel': showAddForm}"
        :title="title"
        @click="showAddForm = !showAddForm"
      >Zutaten</h2>
      <ingredient-list
        :ingredients="$store.getters['ingredients/byGroup']()"
        :multiplier="multiplier"
        :show-add-form="showAddForm"
        :ingredient-group-id="null"
        :first-level-list="true"
        @cancelAdd="showAddForm = false"
        @created="created"
      />
    </div>
    <div :key="key" v-for="(ingredientGroup, key) in ingredientGroups">
      <h2
        class="title is-4"
        :class="{'add-ingredient-form': editmode.enabled && !hasIngredientsWithoutGroup, 'show': !showAddForm, 'cancel': showAddForm}"
        :title="title"
        @click="showAddForm = !showAddForm"
      >{{ ingredientGroup.name }}</h2>
      <ingredient-list
        v-if="$store.getters['ingredients/byGroup'](ingredientGroup.id)"
        :ingredients="$store.getters['ingredients/byGroup'](ingredientGroup.id)"
        :multiplier="multiplier"
        :show-add-form="showAddForm && !hasIngredientsWithoutGroup"
        :ingredient-group-id="ingredientGroup.id"
        :first-level-list="true"
      />
      <span v-else>Keine Zutaten...</span>
    </div>
  </div>
  <div v-else>
    <h2
      class="title is-4"
      :class="{'add-ingredient-form': editmode.enabled, 'show': !showAddForm, 'cancel': showAddForm}"
      :title="title"
      @click="showAddForm = !showAddForm"
    >Zutaten</h2>
    <ingredient-add-form v-if="showAddForm" @cancel="showAddForm = false" @created="created"></ingredient-add-form>
    <span v-else>Keine Zutaten vorhanden!</span>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: ["id", "multiplier"],
  data() {
    return {
      showAddForm: false
    };
  },
  computed: {
    ...mapState({
      ingredientGroups: state => state.ingredient_groups.data,
      ingredients: state => state.ingredients.data,
      recipe: state => state.recipe.data,
      editmode: state => state.recipe.editmode.data
    }),
    title() {
      if (this.editmode.enabled) {
        return "Klicken zum Hinzufügen";
      }
      return "";
    },
    hasIngredientsWithoutGroup() {
      return (
        this.$store.getters["ingredients/byGroup"]() &&
        this.$store.getters["ingredients/byGroup"]().length
      );
    }
  },
  created() {
    this.$store.dispatch("ingredients/index", { recipeId: this.id });
    this.$store.dispatch("ingredient_groups/index", { recipeId: this.id });

    if (this.editmode.enabled) {
      this.$store.dispatch("units/index");
      this.$store.dispatch("foods/index");
      this.$store.dispatch("ingredient_attributes/index");
    }
  },
  methods: {
    created() {
      this.showAddForm = false;
    }
  }
};
</script>

<style lang="scss" scoped>
div.ingredients {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;

  .title.is-4 {
    margin-top: 20px;
  }

  > div {
    padding: 0 35px 30px 30px;

    &.multiple-lists {
      border-right: 1px dotted black;
    }
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
