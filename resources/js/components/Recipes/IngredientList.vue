<template>
  <!-- <div> -->

  <!-- <div> -->
  <ul class="ingredients" v-if="(ingredients && ingredients.length) || showAddForm">
    <h2
      v-if="showTitle"
      class="title is-4"
      :class="{'add-ingredient-form': editMode, 'show': !showAddForm, 'cancel': showAddForm}"
      :title="title"
      @click="showAddForm = !showAddForm"
    >Zutaten</h2>

    <li class="add-ingredient" v-if="editMode && showAddForm">
      <ingredient-add-form
        v-if="showAddForm"
        :recipe-id="recipeId"
        @cancel="showAddForm = false"
        @created="$emit('created')"
        @goUp="goUp()"
        @goDown="goDown()"
      ></ingredient-add-form>
    </li>
    <li :key="ingredient.id" v-for="ingredient in ingredients">
      <ingredient
        :ingredient="ingredient"
        :multiplier="multiplier"
        :recipe-id="recipeId"
        :can-edit="editMode"
        @updated="$emit('updated');"
        @position="$emit('position', $event)"
      ></ingredient>

      <span v-if="ingredient.ingredients && ingredient.ingredients.length">
        <br />Oder:
      </span>
      <ingredient-list
        v-if="ingredient.ingredients && ingredient.ingredients.length"
        :recipeId="recipeId"
        :ingredients="ingredient.ingredients"
        :edit-mode="editMode"
        :multiplier="multiplier"
        @position="$emit('position', { id: $event.id, position: $event.id + ($event.position / 1000) })"
        @created="$emit('created')"
        @updated="$emit('updated')"
      ></ingredient-list>
    </li>
  </ul>
  <span v-else>Keine Zutaten vorhanden!</span>
  <!-- </div> -->
  <!-- </div> -->
</template>

<script>
export default {
  props: ["recipeId", "ingredients", "editMode", "multiplier", "showTitle"],
  data() {
    return {
      showAddForm: false,
      title: ""
    };
  },
  watch: {
    editMode() {
      this.title = "";
      if (this.editMode) {
        this.title = "Klicken zum Hinzufügen";
      }
    }
  },
  mounted() {
    if (this.$route.query.new_ingredient == "true") {
      this.showAddForm = true;
    }
  },
  methods: {
    goUp() {
      const $el = $(`li.add-ingredient`);
      $el.prev().before($el);
    },
    goDown() {
      const $el = $(`li.add-ingredient`);
      $el.next().after($el);
    }
  }
};
</script>

<style lang="scss" scoped>
.ingredients {
  list-style-type: disc;
  margin-left: 15px;
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
