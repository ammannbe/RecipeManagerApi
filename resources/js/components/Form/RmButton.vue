<template>
  <div class="buttons">
    <slot name="buttons"></slot>

    <b-button
      :class="{'is-danger': isDanger}"
      @click="$emit('click')"
      :type="type"
      :disabled="disabled"
    >
      <slot>{{ $t('Confirm') }}</slot>
    </b-button>
  </div>
</template>

<script>
export default {
  props: ["type", "disabled", "isDanger"]
};
</script>

<style lang="scss" scoped>
.buttons {
  align-items: baseline;
  justify-content: space-between;
}
</style>
