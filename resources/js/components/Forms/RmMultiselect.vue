<template>
  <b-field :message="this.message">
    <b-taginput
      v-model="model"
      :data="data | search(filter)"
      autocomplete
      allow-new
      open-on-focus
      field="name"
      :placeholder="placeholder"
      @typing="filter = $event"
    ></b-taginput>
  </b-field>
</template>

<script>
export default {
  props: [
    "value",
    "name",
    "message",
    "min",
    "max",
    "placeholder",
    "disabled",
    "controlsPosition",
    "autofocus",
    "data"
  ],
  data() {
    return { filter: "" };
  },
  computed: {
    model: {
      get() {
        return this.data.filter(el => this.value.indexOf(el.id) != -1) || null;
      },
      set(value) {
        const v = [];
        value.forEach(el => v.push(el.id));
        this.$emit("input", v);
      }
    }
  },
  filters: {
    search(data, filter) {
      return data.filter(
        el =>
          el.name
            .toString()
            .toLowerCase()
            .indexOf(filter.toLowerCase()) >= 0
      );
    }
  }
};
</script>
