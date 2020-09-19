<template>
  <rm-modal-form :title="$t('Edit ingredient')" @close="$emit('close')" @confirm="submit">
    <rm-select
      v-model="ingredient_id"
      :disabled="!ingredients.length"
      :placeholder="$t('Alternate of...')"
    >
      <option
        v-for="ingredient in $store.getters['ingredients/byGroup']()"
        :value="ingredient.id"
        :key="ingredient.id"
      >{{ ingredient.name }}</option>

      <optgroup :key="key" v-for="(group, key) in ingredientGroups" :label="group.name">
        <option
          v-for="ingredient in $store.getters['ingredients/byGroup'](group.id)"
          :value="ingredient.id"
          :key="ingredient.id"
        >{{ ingredient.name }}</option>
      </optgroup>
    </rm-select>

    <rm-numberinput
      :label="$t('Amount')"
      label-position="on-border"
      v-model="amount"
      :min="0"
      :max="999998"
      autofocus
    />

    <rm-numberinput
      :label="$t('Max. amount')"
      label-position="on-border"
      v-model="amount_max"
      :min="0"
      :max="999999"
    />

    <rm-select
      label-position="on-border"
      v-model="unit_id"
      :placeholder="$t('Unit')"
      :options="units"
    />

    <rm-select
      label-position="on-border"
      v-model="food_id"
      :placeholder="$t('Ingredient')"
      :options="foods"
      required
    />

    <rm-multiselect
      label-position="on-border"
      v-model="ingredient_attributes"
      :placeholder="$t('Attributes')"
      :options="ingredientAttributes"
    />

    <rm-autocomplete
      label-position="on-border"
      v-if="!ingredient_id"
      v-model="new_ingredient_group_name"
      @select="ingredient_group_id = $event"
      :placeholder="$t('Group')"
      :options="ingredientGroups"
    />
  </rm-modal-form>
</template>

<script>
import { mapState } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "ingredients/form/getFormFields",
  mutationType: "ingredients/form/updateFormFields"
});

export default {
  props: ["ingredient"],
  data() {
    return {
      new_ingredient_group_name: null
    };
  },
  computed: {
    ...mapState({
      ingredients: state => state.ingredients.data,
      ingredientGroups: state => state.ingredient_groups.data,
      foods: state => state.foods.data,
      units: state => state.units.data,
      ingredientAttributes: state => state.ingredient_attributes.data,
      recipe: state => state.recipe.data,
      form: state => state.ingredients.form.data
    }),
    ...mapFields([
      "ingredient_id",
      "amount",
      "amount_max",
      "unit_id",
      "food_id",
      "ingredient_attributes",
      "ingredient_group_id"
    ])
  },
  created() {
    this.initForm();
    this.$autofocus();
  },
  methods: {
    initForm() {
      const ingredient = this.ingredient;

      this.amount = ingredient.amount;
      this.amount_max = ingredient.amount_max;
      this.unit_id = ingredient.unit_id;
      this.food_id = ingredient.food_id;
      this.ingredient_attributes = ingredient.ingredient_attributes.map(
        i => i.id
      );
      this.ingredient_group_id = ingredient.ingredient_group_id;
      this.ingredient_id = ingredient.ingredient_id;
      this.position = ingredient.position;

      if (this.ingredient_group_id) {
        this.new_ingredient_group_name = ingredient.ingredient_group.name;
      }
    },
    async submit() {
      const recipeId = this.recipe.id;

      if (!this.ingredient_group_id && this.new_ingredient_group_name) {
        try {
          const groupId = await this.$store.dispatch(
            "ingredient_groups/store",
            {
              recipeId,
              name: this.new_ingredient_group_name
            }
          );
          this.ingredient_group_id = groupId;
        } catch (error) {
          console.error(error);
        }
      }

      Object.keys(this.form).forEach(async property => {
        const value = this.form[property];

        if (this.ingredient[property] == value) {
          return;
        }

        await this.$store.dispatch("ingredients/update", {
          id: this.ingredient.id,
          recipeId: this.ingredient.recipe_id,
          property,
          value
        });
      });
    }
  }
};
</script>

<style>
</style>
