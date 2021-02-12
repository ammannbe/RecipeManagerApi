<template>
  <div>
    <li>
      <span @click.prevent="$emit('click', $event)" :class="{'can-edit': editmode.enabled}">
        <span v-if="alternateId">{{ $t('Or') }}:</span>
        {{ ingredient | textify(multiply) }}
      </span>
    </li>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: ["ingredient", "multiplier", "alternateId"],
  computed: {
    ...mapState({
      editmode: state => state.recipe.editmode.data,
    }),
    multiply() {
      if (
        this.multiplier == null ||
        this.multiplier == undefined ||
        this.multiplier == "undefined"
      ) {
        return 1;
      }

      return this.multiplier;
    }
  },
  filters: {
    textify(ingredient, multiply = 1) {
      let text = "";
      if (ingredient.amount !== null) {
        text += (ingredient.amount * multiply).toPrecision(3);
      }
      if (ingredient.amount_max !== null) {
        if (ingredient.amount !== null) {
          text += ` `;
        }
        text += `- ${(ingredient.amount_max * multiply).toPrecision(3)}`;
      }
      if (ingredient.unit !== null) {
        text += ` ${ingredient.unit.name}`;
      }
      if (ingredient.food !== null) {
        text += ` ${ingredient.food.name}`;
      }

      if (ingredient.ingredient_attributes !== []) {
        ingredient.ingredient_attributes.forEach((attribute, index) => {
          if (index === 0) {
            text += " (";
          }
          text += attribute.name;
          if (index !== ingredient.ingredient_attributes.length - 1) {
            text += ", ";
          }
          if (index === ingredient.ingredient_attributes.length - 1) {
            text += ")";
          }
        });
      }
      return text;
    }
  }
};
</script>

<style lang="scss" scoped>
.can-edit {
  cursor: pointer;
}
</style>
