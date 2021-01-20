<template>
  <b-field
    :label-position="labelPosition"
    :horizontal="horizontal"
    :message="message"
    :type="type"
  >
    <template v-if="label" slot="label">
      {{ label }}
      <span v-if="required !== undefined" class="required">*</span>
      <b-tooltip v-if="labelTooltip" type="is-dark" :label="labelTooltip">
        <b-icon size="is-small" icon="question-circle" />
      </b-tooltip>
    </template>
    <textarea id="markdown" :value="model" />
  </b-field>
</template>

<script>
import SimpleMDE from "simplemde";
import "simplemde/dist/simplemde.min.css";

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
    "required"
  ],
  data() {
    return {
      simplemde: null
    };
  },
  computed: {
    model: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit("input", value);
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
  mounted() {
    this.simplemde = new SimpleMDE({
      element: document.getElementById("markdown"),
      spellChecker: false
    });
    this.simplemde.codemirror.on("change", () => {
      this.model = this.simplemde.value();
    });
  }
};
</script>

<style lang="scss" scoped>
.is-danger.border {
  border: 1px solid red;
}
</style>

<style lang="scss">
.editor-toolbar.fullscreen,
.CodeMirror-fullscreen {
  z-index: 9999;
}
</style>
