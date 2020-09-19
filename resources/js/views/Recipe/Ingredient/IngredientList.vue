<template>
  <ul class="ingredients" :class="customClass">
    <li class="add-ingredient" v-if="firstLevelList && editmode.enabled && showAddForm">
      <ingredient-add-form
        @cancel="$emit('cancelAdd')"
        @created="$emit('created')"
        :ingredient-group-id="ingredientGroupId"
      ></ingredient-add-form>
    </li>
    <draggable handle=".handle" :value="ingredients" @end="endDrag($event)">
      <div v-for="ingredient in ingredients" :key="ingredient.position">
        <div class="item">
          <i v-if="editmode.enabled" class="fas fa-arrows-alt handle"></i>
          <i
            v-if="editmode.editing"
            class="fas fa-trash"
            @click.prevent="$emit('remove', { id: ingredient.id, alternateId })"
          ></i>
          <i
            v-if="editmode.editing"
            class="fas fa-edit"
            @click.prevent="$emit('edit', ingredient)"
          ></i>
          <ingredient
            :ingredient="ingredient"
            :multiplier="multiplier"
            :alternate-id="alternateId || null"
            @click.prevent="$emit('edit', ingredient)"
          ></ingredient>
        </div>

        <ingredient-list
          v-if="ingredient.ingredients && ingredient.ingredients.length"
          :show-add-form="false"
          :alternate-id="ingredient.id || null"
          :ingredients="ingredient.ingredients"
          :multiplier="multiplier"
          :ingredient-group-id="ingredientGroupId"
          :first-level-list="false"
          custom-class="child"
          @remove="$emit('remove', $event)"
        ></ingredient-list>
      </div>
    </draggable>
  </ul>
</template>

<script>
import draggable from "vuedraggable";
import { mapState } from "vuex";
import Ingredient from "./Ingredient";
import IngredientAddForm from "./IngredientAddForm";

export default {
  name: "IngredientList", // For recursive components, make sure to provide the "name" option.
  components: {
    draggable,
    Ingredient,
    IngredientAddForm,
    IngredientList: this
  },
  props: [
    "ingredientGroupId",
    "ingredients",
    "multiplier",
    "firstLevelList",
    "showAddForm",
    "alternateId",
    "customClass"
  ],
  computed: {
    ...mapState({
      editmode: state => state.recipe.editmode.data
    })
  },
  methods: {
    endDrag({ oldIndex, newIndex }) {
      if (oldIndex === newIndex) return;

      let ingredients = this.$store.getters["ingredients/byGroup"](
        this.ingredientGroupId
      );

      if (this.alternateId) {
        ingredients = ingredients.find(i => i.id === this.alternateId)
          .ingredients;
      }

      const ingredient = ingredients.find(i => i.position == oldIndex + 1);

      this.$store.dispatch("ingredients/update", {
        id: ingredient.id,
        recipeId: ingredient.recipe_id,
        property: "position",
        value: newIndex + 1
      });
    }
  }
};
</script>

<style lang="scss" scoped>
@import "~bulma/sass/utilities/_all";
@import "resources/sass/variables";

.ingredients {
  list-style-type: disc;
}

.item {
  display: flex;
  align-items: baseline;

  > div {
    margin-left: 20px;
  }

  > .fa-arrows-alt,
  > .fas.fa-trash {
    margin-right: 7px;
  }

  > .fa-trash {
    color: $danger;
  }
}

.child {
  margin-left: 30px;
}
</style>
