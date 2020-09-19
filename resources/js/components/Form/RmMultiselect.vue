<template>
  <b-field :label-position="labelPosition" :horizontal="horizontal" :message="message" :type="type">
    <template v-if="label" slot="label">
      {{ label }}
      <span v-if="required !== undefined" class="required">*</span>
      <b-tooltip v-if="labelTooltip" type="is-dark" :label="labelTooltip">
        <b-icon size="is-small" icon="question-circle" />
      </b-tooltip>
    </template>
    <b-taginput
      v-model="model"
      :data="options | search(filter)"
      autocomplete
      allow-new
      open-on-focus
      field="name"
      :placeholder="placeholder"
      attached
      :size="size"
      @typing="filter = $event"
      style="max-width: 300px"
    ></b-taginput>
  </b-field>
</template>

<script>
export default {
  props: [
    "value",
    "name",
    "label",
    "labelTooltip",
    "labelPosition",
    "horizontal",
    "message",
    "messageType",
    "placeholder",
    "disabled",
    "autofocus",
    "required",

    "min",
    "max",
    "size",
    "controlsPosition",
    "options"
  ],
  data() {
    return { filter: "" };
  },
  computed: {
    model: {
      get() {
        if (this.value === null) {
          return [];
        }

        const filtered = this.options.filter(
          el => this.value.indexOf(el.id) != -1
        );
        return filtered || [];
      },
      set(value) {
        const v = [];
        value.forEach(el => v.push(el.id));
        this.$emit("input", v);
      }
    },
    type() {
      if (!this.message) {
        return;
      }

      if (this.messageType) {
        return this.messageType;
      }

      return "is-danger";
    }
  },
  filters: {
    search(options, filter) {
      return options.filter(
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
