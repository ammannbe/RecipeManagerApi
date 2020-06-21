<template>
  <div class="ingredients" v-if="ingredients.length">
    <div>
      <h2
        class="title is-4"
        :class="{'add-ingredient-form': canEdit, 'show': !showAddForm, 'cancel': showAddForm}"
        :title="title"
        @click="showAddForm = !showAddForm"
      >Zutaten</h2>
      <ingredient-list
        :show-add-form="showAddForm"
        :ingredients="$store.getters['ingredient/byGroup']()"
        :can-edit="canEdit"
        :multiplier="multiplier"
        :first-level-list="true"
        @cancelAdd="showAddForm = false"
      ></ingredient-list>
    </div>
    <div :key="key" v-for="(ingredientGroup, key) in ingredientGroups">
      <h2 class="title is-4">{{ ingredientGroup.name }}</h2>
      <ingredient-list
        :ingredients="$store.getters['ingredient/byGroup'](ingredientGroup.id)"
        :can-edit="canEdit"
        :multiplier="multiplier"
        :first-level-list="true"
      ></ingredient-list>
    </div>
  </div>
  <div v-else>
    <h2
      class="title is-4"
      :class="{'add-ingredient-form': canEdit, 'show': !showAddForm, 'cancel': showAddForm}"
      :title="title"
      @click="showAddForm = !showAddForm"
    >Zutaten</h2>
    <ingredient-add-form
      v-if="showAddForm"
      @cancel="showAddForm = false"
      @created="$store.dispatch('ingredient/index', { recipeId: id })"
    ></ingredient-add-form>
    <span v-else>Keine Zutaten vorhanden!</span>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";

export default {
  props: ["id", "multiplier"],
  data() {
    return {
      showAddForm: false
    };
  },
  computed: {
    ...mapState({
      ingredientGroups: state => state.ingredient_group.ingredientGroups,
      ingredients: state => state.ingredient.ingredients,
      recipe: state => state.recipe.recipe,
      canEdit: state => state.editmode.enabled
    }),
    ...mapGetters({
      grouped: "ingredient/grouped"
    }),
    title() {
      if (this.canEdit) {
        return "Klicken zum Hinzufügen";
      }
      return "";
    }
  },
  created() {
    this.$store.dispatch("unit/index");
    this.$store.dispatch("food/index");
    this.$store.dispatch("ingredient/index", { recipeId: this.id });
    this.$store.dispatch("ingredient_group/index", { recipeId: this.id });
    this.$store.dispatch("ingredient_attribute/index");
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
