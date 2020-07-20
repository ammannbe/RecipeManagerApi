<template>
  <div class="column is-full-tablet">
    <h1 class="title has-text-centered">Zutaten</h1>

    <b-button class="add" @click="add()">+</b-button>

    <form @submit.prevent="$emit('input', forms); $emit('next')">
      <div class="ingredient" v-for="(form, index) in forms" :key="index">
        <rm-numberinput v-model="form.amount" placeholder="Menge" :min="0" :max="999998" autofocus />

        <rm-numberinput v-model="form.amount_max" placeholder="Max. Menge" :min="0" :max="999999" />

        <rm-select v-model="form.unit_id" placeholder="Einheit" :options="units" />

        <rm-select v-model="form.food_id" placeholder="Zutat" :options="foods" required />

        <rm-multiselect
          v-model="form.ingredient_attributes"
          placeholder="Eigenschaften"
          :options="ingredientAttributes"
        />

        <rm-button @click="remove(index)" type="is-danger">
          <i class="fas fa-trash"></i>
        </rm-button>
      </div>

      <rm-submit-button>
        Weiter
        <template v-slot:buttons>
          <b-button @click="$emit('back')" type="is-danger">Zurück</b-button>
        </template>
      </rm-submit-button>
    </form>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  data() {
    return {
      forms: [],
      template: {
        amount: null,
        amount_max: null,
        unit_id: null,
        food_id: null,
        ingredient_attributes: null
      }
    };
  },
  computed: {
    ...mapState({
      foods: state => state.foods.data,
      units: state => state.units.data,
      ingredientAttributes: state => state.ingredient_attributes.data
    })
  },
  created() {
    this.add();
  },
  methods: {
    add() {
      this.forms.push(Object.assign({}, this.template));
    },
    remove(index) {
      if (typeof this.forms[index] === undefined) {
        return;
      }

      delete this.forms.splice(index, 1);
    }
  }
};
</script>

<style lang="scss" scoped>
.column {
  margin-left: 5px;
}

form > div {
  display: flex;
  flex-wrap: wrap;
  justify-content: left;
  margin-top: 5px;

  @media screen and (max-width: 1580px) {
    &:not(:last-child) {
      border-bottom: 1px dotted grey;
    }
  }

  &.ingredient {
    padding: 5px;

    > div,
    > button {
      margin: 2px 5px;
    }
  }
}
</style>
