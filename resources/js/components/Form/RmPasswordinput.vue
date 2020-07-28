<template>
  <b-field :label-position="labelPosition" :horizontal="horizontal" :message="message" :type="type">
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
      :password-reveal="passwordReveal"
      type="password"
      style="max-width: 300px"
    ></b-input>
  </b-field>
</template>

<script>
export default {
  props: [
    "value",
    "name",
    "label",
    "labelTooltip",
    "labelPosition",
    "horizontal",
    "message",
    "messageType",
    "placeholder",
    "disabled",
    "autofocus",
    "required",

    "maxlength",
    "showPassword"
  ],
  computed: {
    model: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit("input", value);
      }
    },
    type() {
      if (!this.message) {
        return;
      }

      if (this.messageType) {
        return this.messageType;
      }

      return "is-danger";
    },
    passwordReveal() {
      if (this.showPassword !== undefined) {
        return this.showPassword;
      }

      return true;
    }
  }
};
</script>

<style lang="scss" scoped>
.required {
  color: red;
}
</style>
