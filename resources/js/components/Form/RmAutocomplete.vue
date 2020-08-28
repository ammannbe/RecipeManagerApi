<template>
  <b-field :label-position="labelPosition" :horizontal="horizontal" :message="message" :type="type">
    <template v-if="label" slot="label">
      {{ label }}
      <span v-if="required !== undefined" class="required">*</span>
      <b-tooltip v-if="labelTooltip" type="is-dark" :label="labelTooltip">
        <b-icon size="is-small" icon="question-circle" />
      </b-tooltip>
    </template>
    <b-autocomplete
      v-model="model"
      :data="filteredOptions"
      :min="min"
      :max="max"
      :placeholder="placeholder"
      :disabled="disabled"
      :controls-position="controlsPosition"
      :size="size"
      :required="required"
      :autofocus="autofocus"
      field="name"
      :open-on-focus="true"
      @select="option => $emit('select', option.id)"
    >
      <slot></slot>
    </b-autocomplete>
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
    },
    filteredOptions() {
      if (!this.options) {
        return [];
      }

      if (!this.model) {
        return this.options;
      }

      return this.options.filter(option => {
        return (
          option.name
            .toString()
            .toLowerCase()
            .indexOf(this.model.toLowerCase()) >= 0
        );
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.required {
  color: red;
}
</style>
