<template>
  <b-field :message="message">
    <b-numberinput
      v-model="model"
      :min="min"
      :max="max"
      :step="step"
      :placeholder="placeholder"
      :disabled="disabled"
      :controls-position="controlsPosition || 'compact'"
      :size="size"
      :autofocus="autofocus"
    ></b-numberinput>
  </b-field>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: [
    "value",
    "message",
    "min",
    "max",
    "step",
    "placeholder",
    "disabled",
    "controlsPosition",
    "size",
    "autofocus"
  ],
  computed: {
    model: {
      get() {
        return parseFloat(this.value);
      },
      set(value) {
        this.$emit("input", parseFloat(value));
      }
    }
  }
};
</script>
