<template>
  <div class="wrapper">
    <div class="arrows">
      <span @click="goUp()" class="fas fa-arrow-up"></span>
      <span @click="goDown()" class="fas fa-arrow-down"></span>
    </div>

    <form
      class="add-ingredient"
      @submit.prevent="submit"
      @change="$store.commit('form/errors/clear', { property: $event.target.name })"
    >
      <select-field
        v-if="ingredients.length"
        name="ingredient_id"
        placeholder="Alternative von"
        nullable
        :data="ingredients"
      ></select-field>

      <div class="field or" v-if="form.ingredient_id">| Oder:</div>
      <input-field name="amount" type="number" max="999998" placeholder="(Min.) Menge" autofocus></input-field>

      <input-field name="amount_max" type="number" max="999999" placeholder="Max. Menge"></input-field>

      <select-field name="unit_id" placeholder="Einheit" nullable :data="units"></select-field>

      <select-field name="food_id" placeholder="Zutat" required inline :data="foods"></select-field>

      <multiselect-field
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

      <submit-button :can-cancel="true" @cancel="$emit('cancel')">Hinzufügen</submit-button>
    </form>
  </div>
</template>

<script>
import Ingredients from "../../modules/ApiClient/Ingredients";
import { mapState } from "vuex";

export default {
  computed: {
    ...mapState({
      ingredients: state => state.ingredient.ingredients,
      ingredientGroups: state => state.ingredient_group.ingredientGroups,
      foods: state => state.food.foods,
      units: state => state.unit.units,
      ingredientAttributes: state =>
        state.ingredient_attribute.ingredientAttributes,
      recipe: state => state.recipe.recipe,
      form: state => state.form.data
    })
  },
  created() {
    this.$store.commit("form/set", {
      data: {
        amount: null,
        amount_max: null,
        unit_id: null,
        food_id: null,
        ingredient_attributes: [],
        ingredient_group_id: null,
        ingredient_id: null,
        position: 0
      }
    });
  },
  mounted() {
    this.$store.dispatch("form/update", {
      property: "position",
      value: this.getPosition()
    });
  },
  methods: {
    goUp() {
      let value = this.form.position;
      if (value > 0) {
        value--;
        this.updatePosition(value);
      }
      this.$emit("goUp");
    },
    goDown() {
      let value = this.form.position;
      if (value <= this.ingredients.length - 1) {
        value++;
        this.updatePosition(value);
      }
      this.$emit("goDown");
    },
    updatePosition(value) {
      this.$store.dispatch("form/update", { property: "position", value });
    },
    getPosition() {
      return $(".ingredients li").index($("li.add-ingredient")[0]) + 1;
    },
    submit() {
      this.updatePosition(this.getPosition());
      this.$store
        .dispatch("form/submit", {
          func: data => new Ingredients(this.recipe.id).store(data)
        })
        .then(() => {
          this.$store.dispatch("ingredient/index", {
            recipeId: this.recipe.id
          });
          this.$emit("created");
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
