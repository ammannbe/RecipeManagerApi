<template>
  <div class="buttons">
    <div class="field is-grouped">
      <div v-if="canCancel" class="control">
        <button @click.prevent="$emit('cancel')" class="button is-danger">
          <slot name="cancel">Abbrechen</slot>
        </button>
      </div>
    </div>

    <div class="field is-grouped">
      <div class="control">
        <slot name="button">
          <button type="submit" class="button is-link" :disabled="disabled">
            <slot>Bestätigen</slot>
          </button>
        </slot>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["can-cancel", "disabled"]
};
</script>
<style lang="scss" scoped>
.buttons {
  align-items: baseline;
  justify-content: space-between;
}
</style>
