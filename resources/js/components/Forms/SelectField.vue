<template>
  <form-field :field="field" :data="data" :form="form" @changed="$emit('changed', $event)">
    <template v-slot:field>
      <div class="select">
        <select v-model="value" :name="field.id" :required="field.required">
          <option
            v-if="field.placeholder"
            :value="null"
            :disabled="!field.nullable"
            selected
          >- {{ field.placeholder }} -</option>
          <option
            :key="el[field.trackBy || 'id']"
            v-for="el in data"
            :value="el[field.trackBy || 'id']"
          >{{ el[field.displayLabel || 'name'] }}</option>
        </select>
      </div>
    </template>
  </form-field>
</template>

<script>
export default {
  props: ["field", "data", "form"],
  data() {
    return { value: null };
  },
  watch: {
    value() {
      this.form.set(this.field.id, this.value);
      this.$emit("changed", {
        id: this.field.id,
        value: this.form.get(this.field.id)
      });
    }
  },
  mounted() {
    this.value = this.form.get(this.field.id);
  }
};
</script>
