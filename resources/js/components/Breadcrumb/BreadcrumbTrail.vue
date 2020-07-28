<template>
  <div>
    <breadcrumb
      :key="path.id"
      v-for="path in paths"
      :text="path.text"
      :name="path.name"
      :query="path.query"
      :is-first="path.isFirst"
    ></breadcrumb>
  </div>
</template>

<script>
export default {
  props: ["category"],
  data() {
    return {};
  },
  computed: {
    paths() {
      return [
        {
          id: 1,
          text: this.$t("Home"),
          name: "home",
          query: {},
          isFirst: true
        },
        { id: 2, text: this.$t("Categories"), name: "categories", query: {} },
        {
          id: 3,
          text: this.category.name,
          name: "home",
          query: { "search[category]": this.category.name }
        }
      ];
    }
  }
};
</script>
