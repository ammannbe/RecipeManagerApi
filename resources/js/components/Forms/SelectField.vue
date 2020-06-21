<template>
  <form-field-template
    :name="name"
    :label="label"
    :icon="icon"
    :required="required"
    :inline="inline"
  >
    <template v-slot:field>
      <div class="select">
        <select v-model="value" :name="name" :required="required">
          <option
            v-if="placeholder"
            :value="null"
            :disabled="!nullable"
            selected
          >- {{ placeholder }} -</option>
          <option
            :key="el[trackByOrId]"
            v-for="el in data"
            :value="el[trackByOrId]"
          >{{ el[displayLabel || 'name'] }}</option>
        </select>
      </div>
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
    "placeholder",
    "required",
    "nullable",
    "inline",
    "displayLabel",
    "data"
  ],
  data() {
    return { value: null };
  },
  computed: {
    ...mapState({
      form: state => state.form.data
    }),
    trackByOrId() {
      return this.trackBy || "id";
    }
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
