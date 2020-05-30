<template>
  <ul class="ingredients">
    <li class="add-ingredient" v-if="firstLevelList && canEdit && showAddForm">
      <ingredient-add-form
        :recipe-id="recipeId"
        :max-position="ingredients.length - 1"
        @cancel="$emit('cancelAdd')"
        @created="$emit('created')"
        @goUp="goUp()"
        @goDown="goDown()"
      ></ingredient-add-form>
    </li>
    <li :key="ingredient.id" v-for="ingredient in ingredients">
      <ingredient
        :ingredient="ingredient"
        :max-position="ingredients.length - 1"
        :multiplier="multiplier"
        :recipe-id="recipeId"
        :can-edit="canEdit"
        @updated="$emit('updated');"
        @removed="$emit('removed');"
        @position="$emit('position', $event)"
      ></ingredient>

      <span v-if="ingredient.ingredients && ingredient.ingredients.length">Oder:</span>
      <ingredient-list
        v-if="ingredient.ingredients && ingredient.ingredients.length"
        :show-add-form="false"
        :recipeId="recipeId"
        :ingredients="ingredient.ingredients"
        :can-edit="canEdit"
        :multiplier="multiplier"
        :first-level-list="false"
        @position="$emit('position', { id: $event.id, position: $event.id + ($event.position / 1000) })"
        @created="$emit('created')"
        @updated="$emit('updated')"
      ></ingredient-list>
    </li>
  </ul>
</template>

<script>
export default {
  props: [
    "recipeId",
    "ingredients",
    "canEdit",
    "multiplier",
    "firstLevelList",
    "showAddForm"
  ],
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
</style>
