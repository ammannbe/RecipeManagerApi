<template>
  <div class="field">
    <label>
      {{ field.label }}
      <div class="control">
        <mavon-editor
          :class="{'is-danger border': showErrors}"
          v-model="value"
          language="de"
          :toolbars="toolbars"
          :required="field.required"
          :placeholder="field.placeholder"
          @save="$emit('saved')"
        ></mavon-editor>
      </div>
    </label>
    <ul v-if="showErrors" class="help is-danger">
      <li :key="error" v-for="error in errors" v-text="error"></li>
    </ul>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: ["field"],
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
  computed: {
    ...mapState({
      form: state => state.form.data,
      errors: state => state.form.errors.data
    }),
    showErrors() {
      return this.$store.getters["form/errors/has"](this.field.id);
    }
  },
  watch: {
    value(value) {
      this.$store.dispatch("form/update", { property: this.field.id, value });
      this.$emit("changed", { id: this.field.id, value });
    }
  },
  created() {
    let value = this.form[this.field.id];
    if (value == null) {
      value = "";
    }
    this.value = value;
  }
};
</script>

<style lang="scss" scoped>
.is-danger.border {
  border: 1px solid red;
}
</style>
