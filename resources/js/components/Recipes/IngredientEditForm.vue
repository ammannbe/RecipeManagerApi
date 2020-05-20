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
            autofocus
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
            @select="multiselectAdd('unit_id', $event.id)"
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
            @select="multiselectAdd('food_id', $event.id)"
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
            @select="multiselectAdd('ingredient_attributes', $event.id)"
            @multiselectRemove="multiselectRemove('ingredient_attributes', $event.id)"
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
            @select="multiselectAdd('ingredient_group_id', $event.id)"
          ></multiselect>
        </template>
      </input-field>

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
  props: ["recipeId", "ingredient", "canEdit"],
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
        isFetched: false,
        data: [],
        selected: null
      },
      foods: {
        isFetched: false,
        data: [],
        selected: null
      },
      ingredientAttributes: {
        isFetched: false,
        data: [],
        selected: []
      },
      ingredientGroups: {
        isFetched: false,
        data: [],
        selected: null
      },
      ingredients: {
        isFetched: false,
        data: [],
        selected: null
      }
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

    setTimeout(() => {
      this.foods.selected = this.foods.data.find(
        food => food.id == this.ingredient.food_id
      );
      this.form._data.food_id = this.ingredient.food_id;
      this.form._data.amount = this.ingredient.amount;
      this.form._data.amount_max = this.ingredient.amount_max;
      this.form._data.unit_id = this.ingredient.unit_id;
      this.form._data.ingredient_attributes = this.ingredient.ingredient_attributes;
      this.form._data.ingredient_group_id = this.ingredient.ingredient_group_id;
      this.form._data.ingredient_id = this.ingredient.ingredient_id;
      this.form._data.position = this.ingredient.position;
      this.ingredientAttributes.selected = this.ingredient.ingredient_attributes;
      this.ingredientGroups.selected = this.ingredient.ingredient_group_id;
      this.ingredients.selected = this.ingredient.ingredient_id;
    }, 1000);
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
    multiselectAdd(key, value) {
      if (key === "ingredient_attributes") {
        this.form._data.ingredient_attributes.push(value);
        return;
      }
      this.form._data[key] = value;
    },
    multiselectRemove(key, value) {
      const index = this.form._data[key].indexOf(value);
      this.form._data[key].splice(index, 1);
    },
    goUp() {
      if (this.form._data.position > 0) {
        this.form._data.position--;
      }
      this.$emit("position", this.form._data.position - 0.0001);
    },
    goDown() {
      if (this.form._data.position < this.ingredients.data.length) {
        this.form._data.position++;
      }
      this.$emit("position", this.form._data.position + 0.0001);
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
