<template>
  <b-field
    :label-position="labelPosition"
    :horizontal="horizontal"
    :message="message"
    :type="type"
  >
    <template v-if="label" slot="label">
      {{ label }}
      <span v-if="required !== undefined" class="required">*</span>
      <b-tooltip v-if="labelTooltip" type="is-dark" :label="labelTooltip">
        <b-icon size="is-small" icon="question-circle" />
      </b-tooltip>
    </template>

    <rm-numberinput
      :label="$t('Hours') + ':'"
      :value="model[0]"
      @input="model = [$event, model[0]]"
      size="is-small"
      :controls="false"
    />
    <rm-numberinput
      :label="$t('Minutes') + ':'"
      :value="model[1]"
      @input="model = [model[1], $event]"
      size="is-small"
      :controls="false"
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
        if (this.value === null || this.value === undefined) {
          return [0, 0];
        }

        return this.value.split(":");
      },
      set(value) {
        const pad = function(n) {
          if (!n) return "00";
          if (n < 10) return "0" + n;
          return n;
        };
        let hours = pad(value[0] || 0);
        let minutes = pad(value[1] || 0);

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
  },
  methods: {
    setHours(hours = null) {
      let time = this.model;
      time[0] = hours;
      this.model = time;
    },
    setMinutes(minutes = null) {
      let time = this.model;
      time[1] = minutes;
      this.model = time;
    }
  }
};
</script>

<style lang="scss">
.has-numberinput {
  flex-grow: unset !important;
}
</style>
