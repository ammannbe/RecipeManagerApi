<template>
  <div class="pagination" :class="position">
    <div v-if="last != 1">
      <div>
        <a v-if="previous" @click="load(previous)" v-html="$t('pagination.previous')"></a>
        <span v-else v-html="$t('pagination.previous')"></span>
        |
        <a v-if="next" @click="load(next)" v-html="$t('pagination.next')"></a>
        <span v-else v-html="$t('pagination.next')"></span>
      </div>

      <span class="pages">
        (
        <span>{{ current }}</span> /
        <a v-if="current !== last" @click="load(last)">{{ last }}</a>
        <span v-else>{{ last }}</span>
        )
      </span>
    </div>
  </div>
</template>

<script>
export default {
  props: ["current", "last", "position", "routeName", "queryUrl"],
  computed: {
    next() {
      if (this.last <= this.current) {
        return false;
      }
      return this.current + 1;
    },
    previous() {
      if (this.current <= 1) {
        return false;
      }
      return this.current - 1;
    }
  },
  mounted() {
    if (this.getUrlQuery() && this.routeName == this.$route.name) {
      this.load(this.getUrlQuery());
    }
  },
  methods: {
    load(page) {
      this.pushPageToRoute(page);
      this.$emit("load", page);
    },
    pushPageToRoute(page = 1) {
      if (!this.queryUrl) {
        return;
      }

      if (this.getUrlQuery() == page) {
        return;
      }

      this.$router.push({
        query: { ...this.$route.query, [this.queryUrl]: page }
      });
    },
    getUrlQuery() {
      return this.$route.query[this.queryUrl] || null;
    }
  }
};
</script>

<style lang="scss" scoped>
.pagination {
  margin: 15px;
  justify-content: end;

  &.start {
    justify-content: start;
  }

  > div {
    display: flex;
    flex-direction: column;
  }
}
</style>
