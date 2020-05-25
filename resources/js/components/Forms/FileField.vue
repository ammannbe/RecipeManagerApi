<template>
  <form-field :field="field" :form="form">
    <template v-slot:field>
      <label class="file-label">
        <input
          type="file"
          :name="field.id"
          :required="field.required"
          :class="field.class || 'file-input'"
          @change="select($event.target.files[0])"
        />
        <span class="file-cta">
          <span class="file-icon">
            <i class="fas fa-upload"></i>
          </span>
          <span class="file-label">Datei wählen</span>
          <span class="help is-danger" v-if="required !== undefined">*</span>
        </span>
        <span class="file-name">{{ filename || 'Keine Datei ausgewählt.' }}</span>
        <i @click.prevent="remove()" class="fas fa-times remove" title="Auswahl entfernen"></i>
      </label>
    </template>
  </form-field>
</template>

<script>
export default {
  props: ["field", "required", "form"],
  data() {
    return {
      file: null
    };
  },
  computed: {
    filename() {
      if (this.file) {
        return this.file.name;
      }
      return null;
    }
  },
  methods: {
    select(file) {
      this.file = file;
      this.$emit("select", file);
    },
    remove() {
      this.file = null;
      this.$emit("remove");
    }
  }
};
</script>

<style lang="scss" scoped>
.remove {
  position: absolute;
  right: 13px;
  top: 12px;
  color: red;
  font-weight: bolder;
}
</style>
