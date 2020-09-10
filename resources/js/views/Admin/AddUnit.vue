<template>
  <rm-modal-form
    :title="$t('Add unit')"
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
      maxlength="20"
      required
      autofocus
    />

    <rm-textinput
      :label="$t('Shortcut') + ':'"
      v-model="name_shortcut"
      :placeholder="$t('Please enter shortcut...')"
      :message="errors.name_shortcut"
      maxlength="20"
    />

    <rm-textinput
      :label="$t('Plural') + ':'"
      v-model="name_plural"
      :placeholder="$t('Please enter plural...')"
      :message="errors.name_plural"
      maxlength="20"
    />

    <rm-textinput
      :label="$t('Plural shortcut') + ':'"
      v-model="name_plural_shortcut"
      :placeholder="$t('Please enter plural shortcut...')"
      :message="errors.name_plural_shortcut"
      maxlength="20"
    />
  </rm-modal-form>
</template>

<script>
import { mapState } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "units/form/getFormFields",
  mutationType: "units/form/updateFormFields"
});

export default {
  computed: {
    ...mapState({
      form: state => state.units.form.data,
      errors: state => state.units.form.errors
    }),
    ...mapFields(["name", "name_shortcut", "name_plural", "name_plural_shortcut"])
  },
  methods: {
    async submit() {
      await this.$store.dispatch("units/store", { data: this.form });

      this.$emit("confirm");
      this.$emit("close");
    }
  }
};
</script>
