<template>
  <span>
    <i v-if="!isFirst" class="fas fa-angle-right"></i>
    <router-link tag="a" :to="{ name, query }">{{ text }}</router-link>
  </span>
</template>

<script>
export default {
  props: ["text", "name", "query", "isFirst"]
};
</script>

<style lang="scss" scoped>
a {
  font-style: italic;
}

i {
  margin: 0 4px;
}
</style>
