<template>
  <ul class="ingredients">
    <li class="add-ingredient" v-if="firstLevelList && canEdit && showAddForm">
      <ingredient-add-form
        @cancel="$emit('cancelAdd')"
        @created="created()"
        @goUp="goUp()"
        @goDown="goDown()"
      ></ingredient-add-form>
    </li>
    <li :key="ingredient.id" v-for="ingredient in ingredients">
      <ingredient
        :ingredient="ingredient"
        :multiplier="multiplier"
        :alternate-id="alternateId || null"
        :can-edit="canEdit"
        :is-any-editing="isAnyEditing"
        @editing="isAnyEditing = $event"
      ></ingredient>

      <span v-if="ingredient.ingredients && ingredient.ingredients.length">Oder:</span>
      <ingredient-list
        v-if="ingredient.ingredients && ingredient.ingredients.length"
        :show-add-form="false"
        :alternate-id="ingredient.id || null"
        :ingredients="ingredient.ingredients"
        :can-edit="canEdit"
        :multiplier="multiplier"
        :first-level-list="false"
      ></ingredient-list>
    </li>
  </ul>
</template>

<script>
export default {
  props: [
    "ingredients",
    "canEdit",
    "multiplier",
    "firstLevelList",
    "showAddForm",
    "alternateId"
  ],
  data() {
    return {
      isAnyEditing: false
    };
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
</style>
