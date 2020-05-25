<template>
  <mavon-editor
    :class="{'is-danger border': form.errors.any()}"
    v-model="value"
    language="de"
    :toolbars="toolbars"
    @change="form.errors.clear(field.id)"
    @save="$emit('saved', { id: field.id, value: value })"
  ></mavon-editor>
</template>

<script>
export default {
  props: ["field", "form"],
  data() {
    return {
      value: this.form.get(this.field.id),

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
  }
};
</script>

<style lang="scss" scoped>
.is-danger.border {
  border: 1px solid red;
}
</style>
