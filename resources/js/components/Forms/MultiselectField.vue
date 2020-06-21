<template>
  <form-field-template
    :name="name"
    :label="label"
    :icon="icon"
    :required="required"
    :inline="inline"
  >
    <template v-slot:field>
      <multiselect
        v-model="value"
        :label="displayLabel || 'name'"
        :placeholder="placeholder"
        :options="data"
        :multiple="multiple || true"
        :close-on-select="closeOnSelect || false"
        :track-by="trackBy"
        :allow-empty="allowEmpty || true"
        @select="add($event)"
        @remove="remove($event)"
      ></multiselect>
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
    "inline",
    "displayLabel",
    "placeholder",
    "multiple",
    "closeOnSelect",
    "trackBy",
    "allowEmpty",
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
  created() {
    this.value = this.data.filter(
      el => this.form[this.name].indexOf(el[this.trackByOrId]) != -1
    );

    if (!this.value.length) {
      this.value = null;
    }
  },
  methods: {
    add(obj) {
      this.$store.dispatch("form/push", {
        property: this.name,
        value: obj[this.trackByOrId]
      });
      this.onChanged();
    },
    remove(obj) {
      this.$store.dispatch("form/remove", {
        property: this.name,
        value: obj[this.trackByOrId]
      });
      this.onChanged();
    },
    onChanged(id, value) {
      this.$emit("changed", {
        id: this.name,
        value: this.form[this.name]
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
.multiselect--active {
  z-index: 9999; // Higher index as MarkdownField
}
</style>
