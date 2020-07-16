<template>
  <b-field :message="this.message">
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
    "message",
    "min",
    "max",
    "placeholder",
    "disabled",
    "controlsPosition",
    "size",
    "required",
    "autofocus",
    "options"
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
