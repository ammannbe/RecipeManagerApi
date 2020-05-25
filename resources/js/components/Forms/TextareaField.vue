<template>
  <form-field :field="field" :form="form">
    <template v-slot:field>
      <textarea
        v-model="value"
        :name="field.id"
        :cols="field.cols || 30"
        :rows="field.rows || 10"
        :maxlength="field.maxlength || 254"
        :placeholder="field.placeholder"
        :required="field.required"
        :class="field.class || 'input'"
      ></textarea>
    </template>
  </form-field>
</template>

<script>
export default {
  props: ["field", "form"],
  data() {
    return { value: null };
  },
  watch: {
    value() {
      this.form.set(this.field.id, this.value);
      this.$emit("changed", this.form.get(this.field.id));
    }
  },
  mounted() {
    this.value = this.form.get(this.field.id);
  }
};
</script>

<style lang="scss" scoped>
textarea {
  height: unset;
}
</style>
