<template>
  <div>
    <link-path
      :key="path.id"
      v-for="path in paths"
      :text="path.text"
      :name="path.name"
      :query="path.query"
      :is-first="path.isFirst"
    ></link-path>
  </div>
</template>

<script>
export default {
  props: ["category"],
  data() {
    return {
      paths: [
        { id: 1, text: "Startseite", name: "home", query: {}, isFirst: true },
        { id: 2, text: "Kategorien", name: "categories", query: {} },
        {
          id: 3,
          text: this.category.name,
          name: "home",
          query: { "search[category]": this.category.name }
        }
      ]
    };
  }
};
</script>

<style lang="scss" scoped>
</style>
