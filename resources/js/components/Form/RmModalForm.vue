<template>
  <form @submit.prevent="$emit('confirm')">
    <div class="modal-card" style="width: auto">
      <header class="modal-card-head">
        <p class="modal-card-title">{{ title }}</p>
        <button type="button" class="delete" @click="$emit('close')" />
      </header>
      <section class="modal-card-body">
        <slot v-bind:errors="errors"></slot>
      </section>
      <footer class="modal-card-foot">
        <slot name="buttons">
          <button class="button" type="button" @click="$emit('close')">
            {{ computedCloseText }}
          </button>
          <button type="submit" class="button is-primary">
            {{ computedConfirmText }}
          </button>
        </slot>
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

<style></style>
