<template>
  <div class="wrapper">
    <div class="arrows">
      <span @click="goUp()" class="fas fa-arrow-up"></span>
      <span @click="goDown()" class="fas fa-arrow-down"></span>
    </div>

    <form
      class="edit-ingredient"
      @submit.prevent="submit"
      @change="form.errors.clear($event.target.name)"
    >
      <select-field
        v-if="ingredients.length"
        :field="{ id: 'ingredient_id', placeholder: 'Alternative von', nullable: true }"
        :data="ingredients"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></select-field>

      <div class="field or" v-if="form.get('ingredient_id')">| Oder:</div>
      <input-field
        :field="{
            id: 'amount',
            type: 'number',
            max: '999998',
            placeholder: '(Min.) Menge',
            autofocus: true
        }"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></input-field>

      <input-field
        :field="{
            id: 'amount_max',
            type: 'number',
            max: '999999',
            placeholder: 'Max. Menge',
        }"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></input-field>

      <select-field
        :field="{ id: 'unit_id', placeholder: 'Einheit', nullable: true }"
        :data="units"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></select-field>

      <select-field
        :field="{ id: 'food_id', placeholder: 'Zutat', required: true }"
        :data="foods"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></select-field>

      <multiselect-field
        v-if="ingredientAttributes.length"
        :field="{ id: 'ingredient_attributes', placeholder: 'Eigenschaften' }"
        :data="ingredientAttributes"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></multiselect-field>

      <select-field
        v-if="ingredientGroups.length"
        :field="{ id: 'ingredient_group_id', placeholder: 'Gruppe', nullable: true }"
        :data="ingredientGroups"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></select-field>

      <submit-button
        :can-cancel="true"
        :disabled="form.errors.any()"
        @cancel="$emit('cancel')"
      >Speichern</submit-button>
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
import Units from "../../modules/ApiClient/Units";
import Foods from "../../modules/ApiClient/Foods";
import Ingredients from "../../modules/ApiClient/Ingredients";
import IngredientAttributes from "../../modules/ApiClient/IngredientAttributes";
import IngredientGroups from "../../modules/ApiClient/IngredientGroups";
import Form from "../../modules/Form";

export default {
  props: ["recipeId", "ingredient", "maxPosition", "canEdit"],
  data() {
    return {
      form: new Form({
        amount: this.ingredient.amount,
        amount_max: this.ingredient.amount_max,
        unit_id: this.ingredient.unit_id,
        food_id: this.ingredient.food_id,
        ingredient_attributes: this.ingredient.ingredient_attributes.map(
          i => i.id
        ),
        ingredient_group_id: this.ingredient.ingredient_group_id,
        ingredient_id: this.ingredient.ingredient_id,
        position: this.ingredient.position
      }),

      units: [],
      foods: [],
      ingredientAttributes: [],
      ingredientGroups: [],
      ingredients: []
    };
  },
  created() {
    let edit = { "edit[ingredient]": this.ingredient.id };
    this.$router.push({ query: { ...this.$route.query, ...edit } });
  },
  destroyed() {
    let query = Object.assign({}, this.$route.query);
    delete query["edit[ingredient]"];
    this.$router.push({ query: query });
  },
  mounted() {
    this.fetch();
  },
  methods: {
    async fetch() {
      this.units = await new Units().index();
      this.foods = await new Foods().index();
      this.ingredientAttributes = await new IngredientAttributes().index();
      this.ingredientGroups = await new IngredientGroups().index({
        recipeId: this.recipeId
      });
      this.ingredients = await new Ingredients(true, this.recipeId).index();
    },
    goUp() {
      let position = this.form.get("position");
      if (position > 0) {
        position--;
        this.form.set("position", position);
      }
      this.$emit("position", position - 0.0001);
    },
    goDown() {
      let position = this.form.get("position");
      if (position < this.maxPosition) {
        position++;
        this.form.set("position", position);
      }
      this.$emit("position", position + 0.0001);
    },
    remove() {
      if (!confirm("Diese Zutat wirklich löschen?")) {
        return;
      }
      new Ingredients(true, this.recipeId)
        .remove(this.ingredient.id)
        .then(() => this.$emit("removed"));
    },
    submit() {
      this.form
        .submit(data =>
          new Ingredients(true, this.recipeId).bulkUpdate(
            this.ingredient.id,
            data
          )
        )
        .then(() => this.$emit("updated"));
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
