<template>
  <b-field :label-position="labelPosition" :horizontal="horizontal" :message="message" :type="type">
    <template v-if="label" slot="label">
      {{ label }}
      <span v-if="required !== undefined" class="required">*</span>
      <b-tooltip v-if="labelTooltip" type="is-dark" :label="labelTooltip">
        <b-icon size="is-small" icon="question-circle" />
      </b-tooltip>
    </template>
    <b-timepicker
      v-model="model"
      :size="size"
      :placeholder="placeholder"
      :open-on-focus="true"
      style="max-width: 300px"
    />
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

    "size"
  ],
  computed: {
    model: {
      get() {
        if (this.value === null) {
          return;
        }

        const [hours, minutes] = this.value.split(":");
        const date = new Date();
        date.setHours(hours);
        date.setMinutes(minutes);

        return date;
      },
      set(value) {
        const pad = function(n) {
          return n < 10 ? "0" + n : n;
        };
        let hours = pad(value.getHours());
        let minutes = pad(value.getMinutes());

        this.$emit("input", `${hours}:${minutes}`);
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
