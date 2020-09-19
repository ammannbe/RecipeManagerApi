<template>
  <div class="wrapper">
    <form class="add-ingredient" @submit.prevent="submit">
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

      <div class="field or" v-if="ingredient_id">| {{ $t('Or') }}:</div>
      <rm-numberinput
        :label="$t('Amount')"
        label-position="on-border"
        v-model="amount"
        :min="0"
        :max="999998"
        :message="errors.amount"
        autofocus
      />

      <rm-numberinput
        :label="$t('Max. amount')"
        label-position="on-border"
        v-model="amount_max"
        :min="0"
        :max="999999"
        :message="errors.amount_max"
      />

      <rm-select
        label-position="on-border"
        v-model="unit_id"
        :placeholder="$t('Unit')"
        :options="units"
        :message="errors.unit_id"
      />

      <rm-select
        label-position="on-border"
        v-model="food_id"
        :placeholder="$t('Ingredient')"
        :options="foods"
        :message="errors.food_id"
        required
      />

      <rm-multiselect
        label-position="on-border"
        v-model="ingredient_attributes"
        :placeholder="$t('Attributes')"
        :options="ingredientAttributes"
        :message="errors.ingredient_attributes"
      />

      <rm-autocomplete
        label-position="on-border"
        v-if="!ingredient_id"
        v-model="new_ingredient_group_name"
        @select="ingredient_group_id = $event"
        :placeholder="$t('Group')"
        :options="ingredientGroups"
        :message="errors.new_ingredient_group_name"
      />

      <rm-submit-button>
        {{ $t('Add') }}
        <template v-slot:buttons>
          <b-button @click="initForm && $emit('cancel')" type="is-danger">{{ $t('Cancel') }}</b-button>
        </template>
      </rm-submit-button>
    </form>
  </div>
</template>

<script>
import { mapState } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "ingredients/form/getFormFields",
  mutationType: "ingredients/form/updateFormFields"
});

export default {
  props: ["ingredientGroupId"],
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
      form: state => state.ingredients.form.data,
      errors: state => state.ingredients.form.errors
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
  },
  mounted() {
    this.$autofocus();
  },
  methods: {
    initForm() {
      this.ingredient_group_id = this.ingredientGroupId;
      this.ingredient_attributes = [];
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
        } catch (error) {}
      }

      await this.$store.dispatch("ingredients/store", {
        recipeId,
        data: this.form
      });
      this.initForm();
    }
  }
};
</script>

<style lang="scss" scoped>
div.wrapper {
  display: flex;
}
</style>

<style lang="scss">
div.wrapper {
  form.add-ingredient {
    display: flex;
    flex-wrap: wrap;

    .field {
      max-width: 200px;
      margin-right: 10px;

      &.or {
        margin-top: 8px;
      }

      select {
        max-width: 160px;
        height: 40px;
      }
    }
  }
}
</style>
