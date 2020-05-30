<template>
  <div class="field">
    <label>
      {{ field.label }}
      <div class="control">
        <mavon-editor
          :class="{'is-danger border': form.errors.any()}"
          v-model="value"
          language="de"
          :toolbars="toolbars"
          :required="field.required"
          :placeholder="field.placeholder"
          @save="$emit('saved')"
        ></mavon-editor>
      </div>
    </label>
    <ul v-if="form.errors.has(field.id)" class="help is-danger">
      <li :key="error" v-for="error in form.errors.get(field.id)" v-text="error"></li>
    </ul>
  </div>
</template>

<script>
export default {
  props: ["field", "form"],
  data() {
    return {
      value: "",

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
    if (this.form.get(this.field.id) != null) {
      this.value = this.form.get(this.field.id);
    }
  }
};
</script>

<style lang="scss" scoped>
.is-danger.border {
  border: 1px solid red;
}
</style>
