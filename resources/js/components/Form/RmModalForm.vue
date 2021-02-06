<template>
  <form @submit.prevent="$emit('submit', $event)">
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
          <button
            class="button"
            type="button"
            @click.prevent="$emit('close', $event)"
          >
            {{ computedCloseText }}
          </button>
          <button class="button is-primary" type="submit">
            {{ computedConfirmText }}
          </button>
          <button
            v-if="nextButton === true"
            class="button is-primary"
            type="submit"
            next
          >
            {{ computedConfirmAndNextText }}
          </button>
        </slot>
      </footer>
    </div>
  </form>
</template>

<script>
export default {
  props: [
    "title",
    "closeText",
    "confirmText",
    "confirmAndNextText",
    "errors",
    "nextButton"
  ],
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
    },
    computedConfirmAndNextText() {
      if (this.confirmAndNextText) {
        return this.confirmAndNextText;
      }

      return this.$t("Save and next");
    }
  },
  mounted() {
    this.$autofocus();
  }
};
</script>

<style lang="scss" scoped>
form {
  margin: 0 5px;
}

footer > .button {
  margin-bottom: 5px;
}
</style>
