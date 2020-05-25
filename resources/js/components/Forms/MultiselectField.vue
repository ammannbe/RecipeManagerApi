<template>
  <form-field :field="field" :data="data" :form="form">
    <template v-slot:field>
      <multiselect
        v-model="value"
        :label="field.displayLabel || 'name'"
        :placeholder="field.placeholder"
        :options="data"
        :multiple="field.multiple || true"
        :close-on-select="field.closeOnSelect || false"
        :track-by="trackBy"
        :allow-empty="field.allowEmpty || true"
        @select="add($event)"
        @remove="remove($event)"
      ></multiselect>
    </template>
  </form-field>
</template>

<script>
export default {
  props: ["field", "data", "form"],
  data() {
    return { value: null };
  },
  computed: {
    trackBy() {
      return this.field.trackBy || "id";
    }
  },
  mounted() {
    this.value = this.data.filter(
      el => this.form.get(this.field.id).indexOf(el[this.trackBy]) != -1
    );

    if (!this.value.length) {
      this.value = null;
    }
  },
  methods: {
    add(obj) {
      this.form.push(this.field.id, obj[this.trackBy]);
      this.$emit("changed", {
        id: this.field.id,
        value: this.form.get(this.field.id)
      });
    },
    remove(obj) {
      this.form.remove(this.field.id, obj[this.trackBy]);
      this.$emit("changed", {
        id: this.field.id,
        value: this.form.get(this.field.id)
      });
    }
  }
};
</script>

<style lang="scss">
.has-icons-left .multiselect__tags {
  padding-left: 2.7em;
}
.multiselect,
.multiselect--above {
  z-index: 5;

  & ~ .icon {
    z-index: 6 !important;
  }
}
</style>
