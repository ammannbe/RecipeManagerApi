<template>
  <div class="wrapper">
    <div class="arrows">
      <span @click="goUp()" class="fas fa-arrow-up"></span>
      <span @click="goDown()" class="fas fa-arrow-down"></span>
    </div>

    <form
      class="edit-ingredient"
      @submit.prevent="submit"
      @change="$store.commit('form/errors/clear', { property: $event.target.name })"
    >
      <select-field
        v-if="ingredients.length"
        name="ingredient_id"
        placeholder="Alternative von..."
        nullable
        :data="ingredients"
      ></select-field>

      <div class="field or" v-if="form && form.ingredient_id">| Oder:</div>
      <input-field name="amount" type="number" max="999998" placeholder="(Min.) Menge" autofocus></input-field>

      <input-field name="amount_max" type="number" max="999999" placeholder="Max. Menge"></input-field>

      <select-field name="unit_id" placeholder="Einheit" nullable :data="units"></select-field>

      <select-field name="food_id" placeholder="Zutat" required inline :data="foods"></select-field>

      <multiselect-field
        v-if="ingredientAttributes.length"
        name="ingredient_attributes"
        placeholder="Eigenschaften"
        :data="ingredientAttributes"
      ></multiselect-field>

      <select-field
        v-if="ingredientGroups.length"
        name="ingredient_group_id"
        placeholder="Gruppe"
        nullable
        :data="ingredientGroups"
      ></select-field>

      <submit-button :can-cancel="true" @cancel="$emit('cancel')">Speichern</submit-button>
      <div class="field is-grouped">
        <div class="control">
          <button @click.prevent="remove()" class="button is-black">
            <slot name="delete">
              <i class="fas fa-trash"></i>
            </slot>
          </button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import Ingredients from "../../modules/ApiClient/Ingredients";
import { mapState } from "vuex";

export default {
  props: ["ingredient", "canEdit", "alternateId"],
  computed: {
    ...mapState({
      ingredients: state => state.ingredient.ingredients,
      ingredientGroups: state => state.ingredient_group.ingredientGroups,
      foods: state => state.food.foods,
      units: state => state.unit.units,
      ingredientAttributes: state => state.ingredient_attribute.data,
      recipe: state => state.recipe.data,
      form: state => state.form.data,
      errors: state => state.form.errors.data
    })
  },
  created() {
    this.$store.commit("form/set", {
      data: {
        amount: this.ingredient.amount,
        amount_max: this.ingredient.amount_max,
        unit_id: this.ingredient.unit_id,
        food_id: this.ingredient.food_id,
        ingredient_attributes: this.ingredient.data.map(i => i.id),
        ingredient_group_id: this.ingredient.ingredient_group_id,
        ingredient_id: this.ingredient.ingredient_id,
        position: this.ingredient.position
      }
    });
  },
  methods: {
    goUp() {
      let value = this.form.position;
      if (value > 0) {
        value--;
        this.$store.dispatch("form/update", { property: "position", value });
      }
      let payload = {
        id: this.ingredient.id,
        alternateId: this.alternateId,
        property: "position",
        value: position - 0.0001
      };
      if (this.alternateId) {
        payload.position /= 1000;
      }
      this.$store.commit("ingredient/changeValue", payload);
      this.$store.commit("ingredient/sort");
    },
    goDown() {
      let value = this.form.position;
      if (value < this.ingredients.length - 1) {
        value++;
        this.$store.dispatch("form/update", { property: "position", value });
      }
      let payload = {
        id: this.ingredient.id,
        alternateId: this.alternateId,
        property: "position",
        value: position + 0.0001
      };
      if (this.alternateId) {
        payload.position /= 1000;
      }
      this.$store.commit("ingredient/changeValue", payload);
      this.$store.commit("ingredient/sort");
    },
    remove() {
      if (!confirm("Diese Zutat wirklich löschen?")) {
        return;
      }
      let id = this.ingredient.id;
      let alternateId = this.alternateId;
      this.$store.dispatch("ingredient/remove", { id, alternateId });
    },
    submit() {
      this.$store
        .dispatch("form/submit", {
          func: data =>
            new Ingredients(this.recipe.id).bulkUpdate(this.ingredient.id, data)
        })
        .then(() => {
          this.$store.dispatch("ingredient/index", {
            recipeId: this.recipe.id
          });
          this.$emit("changed");
        });
    }
  }
};
</script>

<style lang="scss" scoped>
div.wrapper {
  display: flex;

  div.arrows {
    display: flex;
    flex-direction: column;
    margin-right: 3px;

    > span {
      margin: 2px;

      &:nth-child(1) {
        cursor: n-resize;
      }

      &:nth-child(2) {
        cursor: s-resize;
      }
    }
  }
}
</style>

<style lang="scss">
div.wrapper {
  form.edit-ingredient {
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
