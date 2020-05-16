<template>
  <div>
    <ingredient-edit-form
      v-if="canEdit && isEditing == ingredient.id"
      :ingredient="ingredient"
      :recipe-id="recipeId"
      :can-edit="canEdit"
      @cancel="isEditing = false"
      @updated="$emit('updated'); isEditing = false;"
      @position="$emit('position', { id: ingredient.id, position: $event })"
    ></ingredient-edit-form>

    <span
      v-else
      :title="title"
      @click="edit(ingredient)"
      :class="{'can-edit': canEdit}"
    >{{ text(ingredient) }}</span>
  </div>
</template>

<script>
export default {
  props: ["ingredient", "multiplier", "recipeId", "canEdit"],
  data() {
    return {
      isEditing: false,
      multiplyWith: 1,
      title: ""
    };
  },
  mounted() {
    if (this.$route.query.edit_ingredient) {
      this.isEditing = this.$route.query.edit_ingredient;
    }

    if (this.canEdit) {
      this.title = "Klicken zum bearbeiten";
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
    },
    edit(ingredient) {
      if (this.isEditing == ingredient.id) {
        this.isEditing = false;
        return;
      }
      this.isEditing = ingredient.id;
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
