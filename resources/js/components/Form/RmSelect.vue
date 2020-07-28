<template>
  <b-field :label-position="labelPosition" :horizontal="horizontal" :message="message" :type="type">
    <template v-if="label" slot="label">
      {{ label }}
      <span v-if="required !== undefined" class="required">*</span>
      <b-tooltip v-if="labelTooltip" type="is-dark" :label="labelTooltip">
        <b-icon size="is-small" icon="question-circle" />
      </b-tooltip>
    </template>
    <b-select
      v-model="model"
      :min="min"
      :max="max"
      :placeholder="placeholder"
      :disabled="disabled"
      :controls-position="controlsPosition"
      :size="size"
      :required="required"
      :autofocus="autofocus"
    >
      <slot>
        <option
          :key="option.id"
          v-for="option in options || []"
          :value="option.id"
        >{{ option.name }}</option>
      </slot>
    </b-select>
  </b-field>
</template>

<script>
import { mapState } from "vuex";

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

    "min",
    "max",
    "size",
    "options",
    "controlsPosition"
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
    }
  }
};
</script>

<style lang="scss" scoped>
.required {
  color: red;
}
</style>
