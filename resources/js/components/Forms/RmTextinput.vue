<template>
  <b-field :horizontal="horizontal" :message="message">
    <template v-if="label" slot="label">
      {{ label }}
      <span v-if="required !== undefined" class="required">*</span>
      <b-tooltip v-if="labelTooltip" type="is-dark" :label="labelTooltip">
        <b-icon size="is-small" icon="question-circle" />
      </b-tooltip>
    </template>
    <b-input
      v-model="model"
      :maxlength="maxlength"
      :placeholder="placeholder"
      :disabled="disabled"
      :autofocus="autofocus"
      :required="required"
      style="max-width: 300px"
    ></b-input>
  </b-field>
</template>

<script>
export default {
  props: [
    "value",
    "label",
    "labelTooltip",
    "horizontal",
    "message",
    "maxlength",
    "placeholder",
    "disabled",
    "autofocus",
    "required"
  ],
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

<style lang="scss" scoped>
.required {
  color: red;
}
</style>
