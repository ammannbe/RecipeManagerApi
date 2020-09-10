<template>
  <rm-modal-form
    :title="$t('Add user')"
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
      maxlength="255"
      required
      autofocus
    />

    <rm-emailinput
      :label="$t('Email') + ':'"
      v-model="email"
      :placeholder="$t('Please enter email...')"
      :message="errors.email"
      maxlength="255"
      required
      autofocus
    />
  </rm-modal-form>
</template>

<script>
import { mapState } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "users/form/getFormFields",
  mutationType: "users/form/updateFormFields"
});

export default {
  computed: {
    ...mapState({
      form: state => state.users.form.data,
      errors: state => state.users.form.errors
    }),
    ...mapFields(["name", "email"])
  },
  methods: {
    async submit() {
      await this.$store.dispatch("users/store", { data: this.form });

      this.$emit("confirm");
      this.$emit("close");
    }
  }
};
</script>
