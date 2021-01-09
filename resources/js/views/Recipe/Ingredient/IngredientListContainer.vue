<template>
  <div class="ingredients" v-if="ingredients.length">
    <div v-if="hasIngredientsWithoutGroup">
      <h2
        class="title is-4"
        :class="{
          'add-ingredient-form': editmode.enabled,
          show: editmode.enabled
        }"
        :title="title"
        @click="add"
      >
        {{ $t("Ingredients") }}
      </h2>
      <ingredient-list
        :ingredients="$store.getters['ingredients/byGroup']()"
        :multiplier="multiplier"
        :ingredient-group-id="null"
        :first-level-list="true"
        @remove="remove"
        @edit="edit"
        @add="add"
      />
    </div>
    <div :key="key" v-for="(ingredientGroup, key) in ingredientGroups">
      <h2
        v-if="$store.getters['ingredients/byGroup'](ingredientGroup.id)"
        class="title is-4"
        :class="{ 'add-ingredient-form': editmode.enabled }"
        :title="title"
      >
        {{ ingredientGroup.name }}
      </h2>
      <ingredient-list
        v-if="$store.getters['ingredients/byGroup'](ingredientGroup.id)"
        :ingredients="$store.getters['ingredients/byGroup'](ingredientGroup.id)"
        :multiplier="multiplier"
        :ingredient-group-id="ingredientGroup.id"
        :first-level-list="true"
        @remove="remove"
        @edit="edit"
        @add="add"
      />
    </div>
  </div>
  <div v-else class="ingredients">
    <div>
      <h2
        class="title is-4"
        :class="{
          'add-ingredient-form': editmode.enabled,
          show: editmode.enabled
        }"
        :title="title"
        @click="add"
      >
        {{ $t("Ingredients") }}
      </h2>
      <span>{{ $t("No ingredients available...") }}</span>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from "vuex";
import IngredientList from "./IngredientList";
import IngredientEditForm from "./IngredientEditForm";
import IngredientAddForm from "./IngredientAddForm";

export default {
  components: { IngredientList },
  props: ["id", "multiplier"],
  computed: {
    ...mapState({
      ingredientGroups: state => state.ingredient_groups.data,
      ingredients: state => state.ingredients.data,
      recipe: state => state.recipe.data,
      editmode: state => state.recipe.editmode.data
    }),
    ...mapGetters({
      loggedIn: "user/loggedIn"
    }),
    title() {
      if (this.editmode.enabled) {
        return this.$t("Click to add");
      }
      return "";
    },
    hasIngredientsWithoutGroup() {
      return (
        this.$store.getters["ingredients/byGroup"]() &&
        this.$store.getters["ingredients/byGroup"]().length
      );
    }
  },
  created() {
    this.$store.dispatch("ingredients/index", { recipeId: this.id });
    this.$store.dispatch("ingredient_groups/index", { recipeId: this.id });

    setTimeout(() => {
      if (this.loggedIn) {
        this.$store.dispatch("units/index", {});
        this.$store.dispatch("foods/index", {});
        this.$store.dispatch("ingredient_attributes/index", {});
      }
    }, 500);
  },
  methods: {
    ...mapActions({
      remove: "ingredients/remove"
    }),
    edit(ingredient) {
      if (!this.editmode.enabled) {
        return;
      }

      this.$buefy.modal.open({
        parent: this,
        component: IngredientEditForm,
        hasModalCard: true,
        trapFocus: true,
        props: { ingredient }
      });
    },
    add(ingredient_group_id) {
      if (!this.editmode.enabled) {
        return;
      }

      this.$buefy.modal.open({
        parent: this,
        component: IngredientAddForm,
        hasModalCard: true,
        trapFocus: true,
        props: { ingredient_group_id },
        events: {
          next: () => this.add(ingredient_group_id)
        }
      });
    }
  }
};
</script>

<style lang="scss" scoped>
div.ingredients {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;

  .title.is-4 {
    margin-top: 20px;
  }

  > div {
    padding: 0 35px 30px 30px;

    @media screen and (max-width: 1024px) {
      padding: 0;
    }

    &.multiple-lists {
      border-right: 1px dotted black;
    }
  }
}

.add-ingredient-form {
  &.show {
    cursor: copy;
  }
  &.cancel {
    cursor: no-drop;
  }
}
</style>

<style lang="scss">
.modal.is-active {
  z-index: 99999;
}
</style>
