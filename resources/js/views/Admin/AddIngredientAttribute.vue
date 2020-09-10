<template>
  <rm-modal-form
    :title="$t('Add ingredient attribute')"
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
      maxlength="40"
      required
      autofocus
    />
  </rm-modal-form>
</template>

<script>
import { mapState } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "ingredient_attributes/form/getFormFields",
  mutationType: "ingredient_attributes/form/updateFormFields"
});

export default {
  computed: {
    ...mapState({
      form: state => state.ingredient_attributes.form.data,
      errors: state => state.ingredient_attributes.form.errors
    }),
    ...mapFields(["name"])
  },
  methods: {
    async submit() {
      await this.$store.dispatch("ingredient_attributes/store", {
        data: this.form
      });

      this.$emit("confirm");
      this.$emit("close");
    }
  }
};
</script>
