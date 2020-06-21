<template>
  <div class="field">
    <label class="label">
      {{ label }}
      <span v-if="showRequiredMark" class="required" title="Dies ist ein Pflichtfeld">*</span>
      <div class="control" :class="{'has-icons-left has-icons-right': icon}">
        <slot name="field"></slot>

        <span v-if="icon" class="icon is-small is-left">
          <slot name="icon">
            <i :class="icon"></i>
          </slot>
        </span>

        <span v-if="showErrorIcon" class="icon is-small is-right">
          <i class="fas fa-exclamation-triangle"></i>
        </span>
      </div>
    </label>
    <ul v-if="showErrors" class="help is-danger">
      <li :key="error" v-for="error in errors[name]" v-text="error"></li>
    </ul>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: ["name", "label", "icon", "required", "inline"],
  computed: {
    ...mapState({
      errors: state => state.form.errors.data
    }),
    showErrors() {
      return this.$store.getters["form/errors/has"](this.name);
    },
    showErrorIcon() {
      return this.icon && this.showErrors;
    },
    showRequiredMark() {
      return this.required && !this.inline;
    }
  }
};
</script>

<style lang="scss" scoped>
.help.is-danger {
  display: inline;
}
.required {
  color: red;
}
</style>
