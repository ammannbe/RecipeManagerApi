<template>
  <form @submit.prevent="$emit('submit')">
    <div class="modal-card" style="width: auto">
      <header class="modal-card-head">
        <p class="modal-card-title">{{ title }}</p>
        <button type="button" class="delete" @click="$emit('close')" />
      </header>
      <section class="modal-card-body">
        <slot v-bind:errors="errors"></slot>
      </section>
      <footer class="modal-card-foot">
        <button class="button" type="button" @click="$emit('close')">{{ computedCloseText }}</button>
        <button class="button is-primary" @click="$emit('confirm')">{{ computedConfirmText }}</button>
      </footer>
    </div>
  </form>
</template>

<script>
export default {
  props: ["title", "closeText", "confirmText", "errors"],
  computed: {
    computedCloseText() {
      if (this.closeText) {
        return this.closeText;
      }

      return this.$t("Cancel");
    },
    computedConfirmText() {
      if (this.confirmText) {
        return this.confirmText;
      }

      return this.$t("Save");
    }
  },
  mounted() {
    this.$autofocus();
  }
};
</script>

<style>
</style>
