<template>
  <ul class="ingredients" v-if="(ingredients && ingredients.length) || showAddForm">
    <h2
      v-if="showTitle"
      class="title is-4"
      :class="{'add-ingredient-form': editMode, 'show': !showAddForm, 'cancel': showAddForm}"
      :title="title"
      @click="showIngredientAddForm(!showAddForm)"
    >Zutaten</h2>

    <li class="add-ingredient" v-if="firstLevelList && editMode && showAddForm">
      <ingredient-add-form
        :recipe-id="recipeId"
        @cancel="showIngredientAddForm(false)"
        @created="$emit('created')"
        @goUp="goUp()"
        @goDown="goDown()"
      ></ingredient-add-form>
    </li>
    <li :key="ingredient.id" v-for="ingredient in ingredients">
      <ingredient
        :ingredient="ingredient"
        :multiplier="multiplier"
        :recipe-id="recipeId"
        :can-edit="editMode"
        @updated="$emit('updated');"
        @removed="$emit('removed');"
        @position="$emit('position', $event)"
      ></ingredient>

      <span v-if="ingredient.ingredients && ingredient.ingredients.length">
        <br />Oder:
      </span>
      <ingredient-list
        v-if="ingredient.ingredients && ingredient.ingredients.length"
        :recipeId="recipeId"
        :ingredients="ingredient.ingredients"
        :edit-mode="editMode"
        :multiplier="multiplier"
        :first-level-list="false"
        @position="$emit('position', { id: $event.id, position: $event.id + ($event.position / 1000) })"
        @created="$emit('created')"
        @updated="$emit('updated')"
      ></ingredient-list>
    </li>
  </ul>
  <div v-else>
    <h2
      v-if="showTitle"
      class="title is-4"
      :class="{'add-ingredient-form': editMode, 'show': !showAddForm, 'cancel': showAddForm}"
      :title="title"
      @click="showIngredientAddForm(!showAddForm)"
    >Zutaten</h2>
    <span>Keine Zutaten vorhanden!</span>
  </div>
</template>

<script>
export default {
  props: [
    "recipeId",
    "ingredients",
    "editMode",
    "multiplier",
    "showTitle",
    "firstLevelList"
  ],
  data() {
    return {
      showAddForm: false,
      title: ""
    };
  },
  watch: {
    editMode() {
      this.title = "";
      if (this.editMode) {
        this.title = "Klicken zum Hinzufügen";
      }
    }
  },
  mounted() {
    this.showIngredientAddForm(
      this.$route.query["add[ingredient]"] == "true" || false
    );
  },
  methods: {
    goUp() {
      const $el = $(`li.add-ingredient`);
      $el.prev().before($el);
    },
    goDown() {
      const $el = $(`li.add-ingredient`);
      $el.next().after($el);
    },
    showIngredientAddForm(show = true) {
      this.showAddForm = show;

      if (show) {
        let add = { "add[ingredient]": true };
        this.$router.push({ query: { ...this.$route.query, ...add } });
      } else {
        let query = Object.assign({}, this.$route.query);
        delete query["add[ingredient]"];
        this.$router.push({ query });
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.ingredients {
  list-style-type: disc;
  margin-left: 15px;
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
