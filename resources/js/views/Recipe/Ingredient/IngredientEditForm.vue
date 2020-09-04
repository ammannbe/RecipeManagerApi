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
      v-if="amount"
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
    ingredient_id: {
      get() {
        return this.form.ingredient_id;
      },
      set(value) {
        this.updateFormProperty("ingredient_id", value);
      }
    },
    amount: {
      get() {
        return this.form.amount || 0;
      },
      set(value) {
        this.updateFormProperty("amount", value);
      }
    },
    amount_max: {
      get() {
        return this.form.amount_max || 0;
      },
      set(value) {
        this.updateFormProperty("amount_max", value);
      }
    },
    unit_id: {
      get() {
        return this.form.unit_id;
      },
      set(value) {
        this.updateFormProperty("unit_id", value);
      }
    },
    food_id: {
      get() {
        return this.form.food_id;
      },
      set(value) {
        this.updateFormProperty("food_id", value);
      }
    },
    ingredient_attributes: {
      get() {
        return this.form.ingredient_attributes;
      },
      set(value) {
        this.updateFormProperty("ingredient_attributes", value);
      }
    },
    ingredient_group_id: {
      get() {
        return this.form.ingredient_group_id;
      },
      set(value) {
        this.updateFormProperty("ingredient_group_id", value);
      }
    }
  },
  created() {
    this.initForm();
    this.$autofocus();
  },
  methods: {
    initForm() {
      this.$store.commit("ingredients/form/set", {
        data: {
          amount: this.ingredient.amount,
          amount_max: this.ingredient.amount_max,
          unit_id: this.ingredient.unit_id,
          food_id: this.ingredient.food_id,
          ingredient_attributes: this.ingredient.ingredient_attributes,
          ingredient_group_id: this.ingredient.ingredient_group_id,
          ingredient_id: this.ingredient.ingredient_id,
          position: this.ingredient.position
        }
      });
    },
    updateFormProperty(property, value) {
      this.$store.dispatch("ingredients/form/update", { property, value });
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
          await this.updateFormProperty("ingredient_group_id", groupId);
        } catch (error) {
          console.error(error);
        }
      }

      Object.keys(this.form).forEach(async property => {
        const value = this.form[property];

        if (this.ingredient[property] == value) {
          return;
        }

        try {
          await this.$store.dispatch("ingredients/update", {
            id: this.ingredient.id,
            recipeId: this.ingredient.recipe_id,
            property,
            value
          });
        } catch (error) {
          console.error(error);
        }
      });
    }
  }
};
</script>

<style>
</style>
