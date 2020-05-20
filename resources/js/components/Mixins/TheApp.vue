<template>
  <div>
    <header>
      <the-menu-bar @search="searchRecipes($event)"></the-menu-bar>
    </header>

    <router-view></router-view>
  </div>
</template>

<script>
export default {
  methods: {
    searchRecipes(search) {
      const name = "home";
      let query = Object.assign({}, this.$route.query);
      if (search) {
        this.$router.push({ name, query: { ...this.$route.query, search } });
      } else {
        delete query.search;
        this.$router.push({ name, query });
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
