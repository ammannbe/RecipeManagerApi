<template>
  <div class="wrapper">
    <form class="add-ingredient" @submit.prevent="submit">
      <rm-select
        v-model="ingredient_id"
        :disabled="!ingredients.length"
        placeholder="Alternative von..."
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

      <div class="field or" v-if="ingredient_id">| Oder:</div>
      <rm-numberinput
        label="Menge"
        label-position="on-border"
        v-model="amount"
        :min="0"
        :max="999998"
        autofocus
      />

      <rm-numberinput
        label="Max. Menge"
        label-position="on-border"
        v-model="amount_max"
        :min="0"
        :max="999999"
      />

      <rm-select
        label-position="on-border"
        v-model="unit_id"
        placeholder="Einheit"
        :options="units"
      />

      <rm-select
        label-position="on-border"
        v-model="food_id"
        placeholder="Zutat"
        :options="foods"
        required
      />

      <rm-multiselect
        label-position="on-border"
        v-model="ingredient_attributes"
        placeholder="Eigenschaften"
        :options="ingredientAttributes"
      />

      <rm-switch
        label-position="on-border"
        v-if="!ingredient_id && ingredientGroups.length"
        v-model="showNewIngredientGroup"
      >Neue Gruppe</rm-switch>
      <rm-select
        label-position="on-border"
        v-if="ingredientGroups.length && !showNewIngredientGroup && !ingredient_id"
        v-model="ingredient_group_id"
        placeholder="Gruppe"
        :options="ingredientGroups"
      ></rm-select>
      <rm-textinput
        label-position="on-border"
        v-if="(!ingredientGroups.length || showNewIngredientGroup) && !ingredient_id"
        v-model="newIngredientGroupName"
        placeholder="Gruppenname"
      ></rm-textinput>

      <rm-submit-button>
        Hinzufügen
        <template v-slot:buttons>
          <b-button @click="initForm && $emit('cancel')" type="is-danger">Abbrechen</b-button>
        </template>
      </rm-submit-button>
    </form>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: ["ingredientGroupId"],
  data() {
    return {
      showNewIngredientGroup: false,
      newIngredientGroupName: null
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
        return this.form.amount;
      },
      set(value) {
        this.updateFormProperty("amount", value);
      }
    },
    amount_max: {
      get() {
        return this.form.amount_max;
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
  },
  mounted() {
    this.$autofocus();
  },
  methods: {
    initForm() {
      this.$store.commit("ingredients/form/set", {
        data: {
          amount: null,
          amount_max: null,
          unit_id: null,
          food_id: null,
          ingredient_attributes: [],
          ingredient_group_id: this.ingredientGroupId,
          ingredient_id: null,
          position: null
        }
      });
    },
    updateFormProperty(property, value) {
      this.$store.dispatch("ingredients/form/update", { property, value });
    },
    async submit() {
      const recipeId = this.recipe.id;

      if (this.showNewIngredientGroup == true) {
        const groupId = await this.$store.dispatch("ingredient_groups/store", {
          recipeId,
          name: this.newIngredientGroupName
        });
        await this.updateFormProperty("ingredient_group_id", groupId);
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
