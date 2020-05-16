<template>
  <div>
    <pagination
      :current-page="response.current_page"
      :last-page="response.last_page"
      @load="fetchRecipes(filterByName, $event)"
    ></pagination>
    <div class="columns">
      <recipe-card
        v-for="recipe in response.data"
        :key="recipe.id"
        :recipe="recipe"
        class="column is-one-fifth"
      ></recipe-card>
    </div>
  </div>
</template>

<script>
import Recipes from "../../modules/ApiClient/Recipes";

export default {
  props: ["filterByName"],
  data() {
    return {
      response: {}
    };
  },
  mounted() {
    this.fetchRecipes(this.filterByName);
  },
  methods: {
    async fetchRecipes(filterByName = null, page = 1) {
      this.response = await new Recipes().index({
        "filter[name]": filterByName,
        page
      });
    }
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
