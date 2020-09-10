<template>
  <rm-modal-form
    :title="$t('Add food')"
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
      maxlength="50"
      required
      autofocus
    />
  </rm-modal-form>
</template>

<script>
import { mapState } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "foods/form/getFormFields",
  mutationType: "foods/form/updateFormFields"
});

export default {
  computed: {
    ...mapState({
      form: state => state.foods.form.data,
      errors: state => state.foods.form.errors
    }),
    ...mapFields(["name"])
  },
  methods: {
    async submit() {
      await this.$store.dispatch("foods/store", { data: this.form });

      this.$emit("confirm");
      this.$emit("close");
    }
  }
};
</script>
