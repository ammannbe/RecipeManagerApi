<template>
  <b-field :message="message">
    <b-input
      v-model="model"
      :maxlength="maxlength"
      :placeholder="placeholder"
      :disabled="disabled"
      :autofocus="autofocus"
    ></b-input>
  </b-field>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: [
    "value",
    "message",
    "maxlength",
    "placeholder",
    "disabled",
    "autofocus"
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
