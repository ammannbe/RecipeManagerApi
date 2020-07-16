<template>
  <b-field :message="this.message">
    <b-switch v-model="model" :disabled="disabled" :size="size">
      <slot></slot>
    </b-switch>
  </b-field>
</template>

<script>
export default {
  props: ["message", "value", "disabled", "size"],
  computed: {
    model: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit("input", value);
      }
    }
  }
};
</script>

<style>
</style>
