<template>
  <div class="wrapper">
    <div class="arrows">
      <span @click="goUp()" class="fas fa-arrow-up"></span>
      <span @click="goDown()" class="fas fa-arrow-down"></span>
    </div>

    <form
      class="add-ingredient"
      @submit.prevent="submit"
      @change="form.errors.clear($event.target.name)"
    >
      <input-field
        v-if="ingredients.data.length"
        name="ingredient_id"
        :errors="form.errors.get('ingredient_id')"
      >
        <template v-slot:input>
          <select v-model="form._data.ingredient_id" name="ingredients">
            <option :value="null" selected>- Alternative von -</option>
            <option
              :key="ingredient.id"
              v-for="ingredient in ingredients.data"
              :value="ingredient.id"
            >
              <ingredient v-if="ingredient" :ingredient="ingredient"></ingredient>
            </option>
          </select>
        </template>
      </input-field>

      <div class="field or" v-if="form._data.ingredient_id">| Oder:</div>
      <input-field name="amount" required :errors="form.errors.get('amount')">
        <template v-slot:input>
          <input
            v-model="form._data.amount"
            name="amount"
            class="input"
            type="number"
            max="999999"
            placeholder="(Min.) Menge"
            autofocus
          />
        </template>
      </input-field>

      <input-field name="amount_max" required :errors="form.errors.get('amount_max')">
        <template v-slot:input>
          <input
            v-model="form._data.amount_max"
            name="amount_max"
            class="input"
            type="number"
            max="999999"
            placeholder="Max. Menge"
          />
        </template>
      </input-field>

      <input-field name="unit_id" :errors="form.errors.get('unit_id')">
        <template v-slot:input>
          <multiselect
            v-model="units.selected"
            :options="units.data"
            :allow-empty="false"
            deselect-label
            track-by="id"
            placeholder="Einheit"
            label="name"
            select-label
            @select="select('unit_id', $event.id)"
            @input="form.errors.clear('unit_id')"
          ></multiselect>
        </template>
      </input-field>

      <input-field name="food_id" :errors="form.errors.get('food_id')">
        <template v-slot:input>
          <multiselect
            v-model="foods.selected"
            :options="foods.data"
            :allow-empty="false"
            deselect-label
            track-by="id"
            placeholder="Zutat"
            label="name"
            select-label
            @select="select('food_id', $event.id)"
            @input="form.errors.clear('food_id')"
          ></multiselect>
        </template>
      </input-field>

      <input-field name="ingredient_attributes" :errors="form.errors.get('ingredient_attributes')">
        <template v-slot:input>
          <multiselect
            v-model="ingredientAttributes.selected"
            :options="ingredientAttributes.data"
            :multiple="true"
            :close-on-select="false"
            track-by="id"
            placeholder="Eigenschaften"
            label="name"
            select-label
            @select="select('ingredient_attributes', $event.id)"
            @remove="remove('ingredient_attributes', $event.id)"
          ></multiselect>
        </template>
      </input-field>

      <input-field name="ingredient_group_id" :errors="form.errors.get('ingredient_group_id')">
        <template v-slot:input>
          <multiselect
            v-model="ingredientGroups.selected"
            :options="ingredientGroups.data"
            :allow-empty="false"
            deselect-label
            track-by="id"
            placeholder="Gruppe"
            label="name"
            select-label
            @select="select('ingredient_group_id', $event.id)"
          ></multiselect>
        </template>
      </input-field>

      <submit-button
        :can-cancel="true"
        :disabled="form.errors.any()"
        @cancel="$emit('cancel')"
      >Hinzufügen</submit-button>
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
  props: ["recipeId"],
  data() {
    return {
      form: new Form({
        amount: null,
        amount_max: null,
        unit_id: null,
        food_id: null,
        ingredient_attributes: [],
        ingredient_group_id: null,
        ingredient_id: null,
        position: 0
      }),

      units: {
        data: [],
        selected: null
      },
      foods: {
        data: [],
        selected: null
      },
      ingredientAttributes: {
        data: [],
        selected: []
      },
      ingredientGroups: {
        data: [],
        selected: null
      },
      ingredients: {
        data: [],
        selected: null
      }
    };
  },
  watch: {
    ingredientId() {
      this.form._data.ingredient_id = this.ingredientId;
    }
  },
  mounted() {
    this.form._data.position = this.getPosition();

    this.fetch();
  },
  methods: {
    async fetch() {
      this.units.data = await new Units().index();
      this.foods.data = await new Foods().index();
      this.ingredientAttributes.data = await new IngredientAttributes().index();
      this.ingredientGroups.data = await new IngredientGroups().index({
        recipeId: this.recipeId
      });
      this.ingredients.data = await new Ingredients(
        true,
        this.recipeId
      ).index();
    },
    select(key, value) {
      if (key === "ingredient_attributes") {
        this.form._data.ingredient_attributes.push(value);
        return;
      }
      this.form._data[key] = value;
    },
    remove(key, value) {
      const index = this.form._data[key].indexOf(value);
      this.form._data[key].splice(index, 1);
    },
    goUp() {
      this.$emit("goUp");
      if (this.form._data.position > 1) {
        this.form._data.position--;
      }
    },
    goDown() {
      this.$emit("goDown");
      if (this.form._data.position <= this.ingredients.data.length) {
        this.form._data.position++;
      }
    },
    getPosition() {
      return $(".ingredients li").index($("li.add-ingredient")[0]) + 1;
    },
    submit() {
      this.form._data.position = this.getPosition();

      this.form
        .submit(data => new Ingredients(true, this.recipeId).store(data))
        .then(() => this.$emit("created"));
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
