<template>
  <rm-modal-form
    :title="$t('Add tag')"
    :errors="errors"
    @close="$emit('close')"
    @confirm="submit"
    v-slot="{ errors }"
  >
    <rm-textinput
      :label="$t('Name') + ':'"
      v-model="name"
      :placeholder="$t('Please enter name...')"
      :message="errors.name"
      maxlength="25"
      required
      autofocus
    />
  </rm-modal-form>
</template>

<script>
import { mapState } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "tags/form/getFormFields",
  mutationType: "tags/form/updateFormFields"
});

export default {
  computed: {
    ...mapState({
      form: state => state.tags.form.data,
      errors: state => state.tags.form.errors
    }),
    ...mapFields(["name"])
  },
  methods: {
    async submit() {
      await this.$store.dispatch("tags/store", { data: this.form });

      this.$emit("confirm");
      this.$emit("close");
    }
  }
};
</script>
