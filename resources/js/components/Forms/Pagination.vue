<template>
  <div class="pagination">
    <div>
      <a v-if="prevPage" @click="$emit('load', prevPage)">&#60;&#60;</a>
      <span v-else>&#60;&#60;</span>

      <span class="pages">
        Seite
        <span>{{ currentPage }}</span> von
        <a v-if="currentPage !== lastPage" @click="$emit('load', lastPage)">{{ lastPage }}</a>
        <span v-else>{{ lastPage }}</span>
      </span>

      <a v-if="nextPage" @click="$emit('load', nextPage)">&#62;&#62;</a>
      <span v-else>&#62;&#62;</span>
    </div>
  </div>
</template>

<script>
export default {
  props: ["currentPage", "lastPage"],
  watch: {
    currentPage() {
      this.pushCurrentPageToRoute();
    }
  },
  mounted() {
    this.pushCurrentPageToRoute();
  },
  computed: {
    nextPage() {
      if (this.lastPage <= this.currentPage) {
        return false;
      }
      return this.currentPage + 1;
    },
    prevPage() {
      if (this.currentPage <= 1) {
        return false;
      }
      return this.currentPage - 1;
    },
    pushCurrentPageToRoute() {
      let page = this.currentPage;
      this.$router.push({ query: { ...this.$route.query, page } });
    }
  }
};
</script>

<style lang="scss" scoped>
.pagination {
  justify-content: end;
}
</style>
