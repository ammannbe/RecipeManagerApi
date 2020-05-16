<template>
  <div>
    <h1 class="title has-text-centered">Übersicht Rezepte</h1>
    <p v-if="$route.query.search">Suche nach "{{ $route.query.search }}"</p>
    <hr />
    <recipe-card-list :filter-by-name="$route.query.search"></recipe-card-list>
  </div>
</template>

<style lang="scss" scoped>
.columns {
  padding-left: 50px;
  padding-right: 50px;

  .column {
    margin: 10px;
  }
}
</style>
