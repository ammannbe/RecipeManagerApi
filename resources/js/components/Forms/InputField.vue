<template>
  <form-field-template
    :name="name"
    :label="label"
    :icon="icon"
    :required="required"
    :inline="inline"
  >
    <template v-slot:field>
      <input
        v-model="value"
        :name="name"
        :type="type || 'text'"
        :min="min"
        :max="max"
        :maxlength="maxlength"
        :step="step"
        :placeholder="placeholder"
        :required="required"
        :autofocus="autofocus"
        :class="fieldClass || 'input'"
      />
    </template>
  </form-field-template>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: [
    "name",
    "label",
    "icon",
    "required",
    "autofocus",
    "inline",
    "fieldClass",
    "type",
    "min",
    "max",
    "maxlength",
    "step",
    "placeholder"
  ],
  data() {
    return { value: null };
  },
  computed: {
    ...mapState({
      form: state => state.form.data
    })
  },
  watch: {
    value(value) {
      this.$store.dispatch("form/update", { property: this.name, value });
      this.$emit("changed", { id: this.name, value });
    }
  },
  created() {
    this.value = this.form[this.name];
  }
};
</script>
