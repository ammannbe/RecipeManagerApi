<template>
  <div class="field">
    <label class="label">
      {{ field.label }}
      <div class="control" :class="{'has-icons-left has-icons-right': field.icon}">
        <slot name="field"></slot>

        <span v-if="field.icon" class="icon is-small is-left">
          <slot name="icon">
            <i :class="field.icon"></i>
          </slot>
        </span>

        <span v-if="field.icon && form.errors.has(field.id)" class="icon is-small is-right">
          <i class="fas fa-exclamation-triangle"></i>
        </span>
      </div>
    </label>
    <ul v-if="form.errors.has(field.id)" class="help is-danger">
      <li :key="error" v-for="error in form.errors.get(field.id)" v-text="error"></li>
    </ul>
  </div>
</template>

<script>
export default {
  props: ["field", "form"]
};
</script>

<style lang="scss" scoped>
.help.is-danger {
  display: inline;
}
</style>
