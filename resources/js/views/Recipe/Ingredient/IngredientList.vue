<template>
  <ul class="ingredients" :class="customClass">
    <draggable handle=".handle" :value="ingredients" @end="endDrag($event)">
      <div v-for="ingredient in ingredients" :key="ingredient.position">
        <div class="item">
          <i v-if="editmode.editing" class="fas fa-arrows-alt handle"></i>
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

export default {
  name: "IngredientList", // For recursive components, make sure to provide the "name" option.
  components: { draggable, Ingredient, IngredientList: this },
  props: [
    "ingredientGroupId",
    "ingredients",
    "multiplier",
    "firstLevelList",
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
        data: { position: newIndex + 1 }
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
  > .fas.fa-trash,
  > .fas.fa-edit {
    margin-right: 10px;

    @media screen and (max-width: 768px) {
      margin-right: 15px;
    }
  }

  > .fa-trash {
    color: $danger;
  }
}

.child {
  margin-left: 30px;
}
</style>
