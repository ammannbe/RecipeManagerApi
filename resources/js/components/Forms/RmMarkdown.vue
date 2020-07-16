<template>
  <b-field :horizontal="horizontal" :message="message">
    <template v-if="label" slot="label">
      {{ label }}
      <span v-if="required !== undefined" class="required">*</span>
      <b-tooltip v-if="labelTooltip" type="is-dark" :label="labelTooltip">
        <b-icon size="is-small" icon="question-circle" />
      </b-tooltip>
    </template>
    <mavon-editor
      :class="{'is-danger border': !!message}"
      v-model="model"
      language="de"
      :toolbars="toolbars"
      :placeholder="placeholder"
      :autofocus="autofocus"
      @save="$emit('save')"
    ></mavon-editor>
  </b-field>
</template>

<script>
import "mavon-editor/dist/css/index.css";

export default {
  props: [
    "value",
    "label",
    "labelTooltip",
    "horizontal",
    "message",
    "placeholder",
    "autofocus",
    "required"
  ],
  data() {
    return {
      toolbars: {
        bold: true,
        italic: true,
        header: true,
        underline: true,
        strikethrough: true,
        mark: true,
        superscript: true,
        subscript: true,
        quote: true,
        ol: true,
        ul: true,
        link: true,
        imagelink: false,
        code: true,
        table: true,
        fullscreen: true,
        readmodel: true,
        htmlcode: true,
        help: true,
        /* 1.3.5 */
        undo: true,
        redo: true,
        trash: true,
        save: true,
        /* 1.4.2 */
        navigation: false,
        /* 2.1.8 */
        alignleft: true,
        aligncenter: true,
        alignright: true,
        /* 2.2.1 */
        subfield: true,
        preview: true
      }
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
    }
  }
};
</script>

<style lang="scss" scoped>
.is-danger.border {
  border: 1px solid red;
}
</style>
