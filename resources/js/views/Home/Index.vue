<template>
  <div>
    <h1 class="title has-text-centered">{{ $t('Recipes Overview') }}</h1>
    <p v-if="$route.query.search">{{ $t('Search for', { search: $route.query.search }) }}</p>
    <hr />
    <recipe-card-list :filter-by-name="$route.query.search"></recipe-card-list>
  </div>
</template>

<script>
import RecipeCardList from "./RecipeCardList";

export default {
  components: { RecipeCardList }
};
</script>

<style lang="scss" scoped>
.columns {
  padding-left: 50px;
  padding-right: 50px;

  .column {
    margin: 10px;
  }
}
</style>
