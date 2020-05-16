<template>
  <div class="field">
    <label class="label">
      {{ label }}
      <div
        class="control"
        :class="{'has-icons-left has-icons-right': $slots.hasOwnProperty('icon')}"
      >
        <slot name="input">
          <input
            :name="name"
            :type="type"
            :placeholder="placeholder"
            :required="required"
            class="input"
          />
        </slot>

        <span v-if="$slots.hasOwnProperty('icon')" class="icon is-small is-left">
          <slot name="icon"></slot>
        </span>

        <span v-if="$slots.hasOwnProperty('icon') && errors.length" class="icon is-small is-right">
          <i class="fas fa-exclamation-triangle"></i>
        </span>
      </div>
    </label>
    <ul v-if="errors.length" class="help is-danger">
      <li :key="error" v-for="error in errors" v-text="error"></li>
    </ul>
  </div>
</template>

<script>
export default {
  props: ["label", "name", "type", "placeholder", "required", "errors", "value"]
};
</script>

<style lang="scss" scoped>
textarea {
  height: unset;
}

.help.is-danger {
  display: inline;
}
</style>

<style lang="scss">
.has-icons-left .multiselect__tags {
  padding-left: 2.5em;
}
.multiselect,
.multiselect--above {
  z-index: 5;

  & ~ .icon {
    z-index: 6 !important;
  }
}
</style>
