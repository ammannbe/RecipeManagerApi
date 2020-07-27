<template>
  <div class="pagination" :class="position">
    <div v-if="lastPage != 1">
      <a v-if="prevPage" @click="$emit('load', prevPage)" v-html="$t('pagination.previous')"></a>

      <span class="pages">
        [
        <span>{{ currentPage }}</span> /
        <a v-if="currentPage !== lastPage" @click="$emit('load', lastPage)">{{ lastPage }}</a>
        <span v-else>{{ lastPage }}</span>
        ]
      </span>

      <a v-if="nextPage" @click="$emit('load', nextPage)" v-html="$t('pagination.next')"></a>
    </div>
  </div>
</template>

<script>
export default {
  props: ["currentPage", "lastPage", "position", "queryPage"],
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
    }
  },
  mounted() {
    if (this.queryPage) {
      this.pushCurrentPageToRoute();
    }
  },
  methods: {
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

  &.start {
    justify-content: start;
  }
}
</style>
