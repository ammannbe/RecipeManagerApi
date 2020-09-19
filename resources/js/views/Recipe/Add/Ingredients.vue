<template>
  <div class="column is-full-tablet">
    <h1 class="title has-text-centered">{{ $t('Ingredients') }}</h1>

    <form @submit.prevent="$emit('input', forms); $emit('next')">
      <draggable handle=".handle" v-model="forms">
        <div class="ingredient" v-for="(form, index) in forms" :key="index">
          <div class="field handle-container">
            <i class="fas fa-arrows-alt handle"></i>
          </div>

          <rm-numberinput
            v-model="form.amount"
            :placeholder="$t('Amount')"
            :min="0"
            :max="999998"
            autofocus
          />

          <rm-numberinput
            v-model="form.amount_max"
            :placeholder="$t('Max. amount')"
            :min="0"
            :max="999999"
          />

          <rm-select v-model="form.unit_id" :placeholder="$t('Unit')" :options="units" />

          <rm-select
            v-model="form.food_id"
            :placeholder="$t('Ingredient')"
            :options="foods"
            required
          />

          <rm-multiselect
            v-model="form.ingredient_attributes"
            :placeholder="$t('Attributes')"
            :options="ingredientAttributes"
          />

          <rm-button @click="remove(index)" type="is-danger">
            <i class="fas fa-trash"></i>
          </rm-button>
        </div>
      </draggable>

      <div class="add-button">
        <b-button @click="add()">
          <span>
            <i class="fas fa-plus"></i>
            {{ $t('Add more ingredients') }}
          </span>
        </b-button>
      </div>

      <rm-submit-button>
        Weiter
        <template v-slot:buttons>
          <b-button @click="$emit('back')" type="is-danger">{{ $t('Back') }}</b-button>
        </template>
      </rm-submit-button>
    </form>
  </div>
</template>

<script>
import draggable from "vuedraggable";
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

div.add-button {
  display: flex;
  justify-content: flex-end;
  margin: 10px 0;
}

div.handle-container {
  display: flex;
  align-items: center;
  font-size: 1.4em;
}

form .ingredient {
  display: flex;
  flex-wrap: wrap;
  justify-content: left;
  align-items: center;
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
