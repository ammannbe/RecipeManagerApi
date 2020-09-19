<template>
  <div>
    <li>
      <span @click.prevent="$emit('click', $event)">
        <span v-if="alternateId">{{ $t('Or') }}:</span>
        {{ ingredient | textify(multiply) }}
      </span>
    </li>
  </div>
</template>

<script>
export default {
  props: ["ingredient", "multiplier", "alternateId"],
  computed: {
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
        text += Math.round(ingredient.amount * multiply);
      }
      if (ingredient.amount_max !== null) {
        if (ingredient.amount !== null) {
          text += ` `;
        }
        text += `- ${Math.round(ingredient.amount_max * multiply)}`;
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
li > span {
  cursor: pointer;
}
</style>
