<template>
  <ul class="ingredients" :class="customClass">
    <li class="add-ingredient" v-if="firstLevelList && editmode.enabled && showAddForm">
      <ingredient-add-form @cancel="$emit('cancelAdd')" @created="$emit('created')"></ingredient-add-form>
    </li>
    <draggable handle=".handle" :value="ingredients" @start="drag=true" @end="endDrag($event)">
      <div v-for="ingredient in ingredients" :key="ingredient.position">
        <div class="item">
          <i v-if="firstLevelList && editmode.enabled" class="fas fa-arrows-alt handle"></i>
          <ingredient
            :ingredient="ingredient"
            :multiplier="multiplier"
            :alternate-id="alternateId || null"
            :is-any-editing="isAnyEditing"
            @editing="isAnyEditing = $event"
          ></ingredient>
        </div>

        <ingredient-list
          v-if="ingredient.ingredients && ingredient.ingredients.length"
          :show-add-form="false"
          :alternate-id="ingredient.id || null"
          :ingredients="ingredient.ingredients"
          :multiplier="multiplier"
          :first-level-list="false"
          custom-class="child"
        ></ingredient-list>
      </div>
    </draggable>
  </ul>
</template>

<script>
import draggable from "vuedraggable";
import { mapState } from "vuex";

export default {
  components: {
    draggable
  },
  props: [
    "ingredients",
    "multiplier",
    "firstLevelList",
    "showAddForm",
    "alternateId",
    "customClass"
  ],
  data() {
    return {
      isAnyEditing: false
    };
  },
  computed: {
    ...mapState({
      editmode: state => state.recipe.editmode.data
    })
  },
  methods: {
    endDrag($event, groupId = null) {
      const ingredients = this.$store.getters["ingredient/byGroup"](groupId);
      const ingredient = ingredients.find(
        el => el.position == $event.oldIndex + 1
      );

      this.$store.dispatch("ingredient/update", {
        id: ingredient.id,
        recipeId: ingredient.recipe_id,
        property: "position",
        value: $event.newIndex + 1
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.ingredients {
  list-style-type: disc;
}

.item {
  display: flex;
  align-items: center;

  > div {
    margin-left: 20px;
  }

  > .handle {
    cursor: pointer;
  }
}

.child {
  margin-left: 30px;
}
</style>
