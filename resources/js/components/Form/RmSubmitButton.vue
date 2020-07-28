<template>
  <div class="buttons">
    <slot name="buttons"></slot>

    <b-button native-type="submit" :disabled="disabled">
      <slot>{{ $t('Confirm') }}</slot>
    </b-button>
  </div>
</template>

<script>
export default {
  props: ["disabled"]
};
</script>

<style lang="scss" scoped>
.buttons {
  align-items: baseline;
  justify-content: space-between;
}
</style>
