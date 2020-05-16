<template>
  <div>
    <header>
      <the-menu-bar @search="searchRecipes($event)"></the-menu-bar>
    </header>

    <router-view></router-view>
  </div>
</template>

<script>
import RouteQueryHelper from "../../modules/RouteQueryHelper";

export default {
  methods: {
    searchRecipes(search) {
      const name = "home";
      let query = this.$route.query;
      if (search) {
        query = RouteQueryHelper.pushOrReplace(query, "search", search);
        this.$router.push({ query, name });
      } else {
        query = RouteQueryHelper.remove(query, "search");
        this.$router.push({ query, name });
      }

      this.$router.go();
    }
  }
};
</script>

<style lang="scss" scoped>
header {
  height: 88px;
}
</style>
