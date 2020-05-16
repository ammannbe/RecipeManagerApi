<template>
  <div class="field file has-name is-fullwidth">
    <label class="file-label">
      <slot name="input">
        <input
          :name="name"
          type="file"
          :required="required"
          class="file-input"
          @change="select($event)"
        />
      </slot>
      <span class="file-cta">
        <span class="file-icon">
          <i class="fas fa-upload"></i>
        </span>
        <span class="file-label">{{ label }}</span>
        <span class="help is-danger" v-if="required !== undefined">*</span>
      </span>
      <span class="file-name">{{ filename || 'Keine Datei ausgewählt.' }}</span>
      <i @click.prevent="remove($event)" class="fas fa-times remove" title="Auswahl entfernen"></i>
    </label>
    <ul v-if="errors.length" class="help is-danger">
      <li :key="error" v-for="error in errors" v-text="error"></li>
    </ul>
  </div>
</template>

<script>
export default {
  props: ["label", "name", "required", "errors", "value", "file"],
  data() {
    return {
      filename: null
    };
  },
  watch: {
    file() {
      if (this.file) {
        this.filename = this.file.name;
      }

      if (!this.file) {
        this.filename = null;
      }
    }
  },
  methods: {
    select($event) {
      this.$emit("update:file", $event.target.files[0]);
    },
    remove($event) {
      this.$emit("update:file", null);
    }
  }
};
</script>

<style lang="scss" scoped>
textarea {
  height: unset;
}

.help.is-danger {
  display: inline;
}

.remove {
  position: absolute;
  right: 13px;
  top: 12px;
  color: red;
  font-weight: bolder;
}
</style>
