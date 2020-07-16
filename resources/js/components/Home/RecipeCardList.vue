<template>
  <div>
    <pagination
      :current-page="recipes.current_page"
      :last-page="recipes.last_page"
      @load="$store.dispatch('recipes/index', { page: $event, filter })"
    ></pagination>
    <div class="columns">
      <recipe-card
        v-for="recipe in recipes.data"
        :key="recipe.id"
        :recipe="recipe"
        class="column is-one-fifth"
      ></recipe-card>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: ["filterByName"],
  computed: {
    ...mapState({
      recipes: state => state.recipes.data
    }),
    filter() {
      if (this.filterByName) {
        return { "filter[name]": this.filterByName };
      }
      return null;
    }
  },
  created() {
    this.$store.dispatch("recipes/index", { filter: this.filter });
  }
};
</script>

<style lang="scss" scoped>
div.columns {
  flex-wrap: wrap;

  > .column {
    margin: 10px;
  }
}
</style>
