<template>
  <div>
    <ingredient-edit-form
      v-if="canEdit && isEditing"
      :ingredient="ingredient"
      :alternate-id="alternateId"
      :can-edit="canEdit"
      @cancel="edit(false)"
      @changed="edit(false)"
    ></ingredient-edit-form>

    <span
      v-else
      :title="title"
      @click="edit(true)"
      :class="{'can-edit': canEdit && !isAnyEditing}"
    >{{ text(ingredient) }}</span>
  </div>
</template>

<script>
export default {
  props: ["ingredient", "multiplier", "canEdit", "alternateId", "isAnyEditing"],
  data() {
    return {
      isEditing: false,
      multiplyWith: 1
    };
  },
  computed: {
    title() {
      if (this.canEdit) {
        return "Klicken zum Bearbeten";
      }
      return "";
    }
  },
  watch: {
    multiplier() {
      if (
        this.multiplier != null &&
        this.multiplier != undefined &&
        this.multiplier != "undefined"
      ) {
        this.multiplyWith = this.multiplier;
      }
    }
  },
  methods: {
    edit(edit) {
      if (this.isAnyEditing && !this.isEditing) {
        return;
      }
      this.isEditing = edit;
      this.$emit("editing", edit);
    },
    text(ingredient) {
      let text = "";
      if (ingredient.amount !== null) {
        text += Math.round(ingredient.amount * this.multiplyWith);
      }
      if (ingredient.amount_max !== null) {
        if (ingredient.amount !== null) {
          text += ` `;
        }
        text += `- ${Math.round(ingredient.amount_max * this.multiplyWith)}`;
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
.alternates {
  display: inline-block;

  > span {
    display: block;
  }
}

.can-edit {
  cursor: pointer;
}
</style>
