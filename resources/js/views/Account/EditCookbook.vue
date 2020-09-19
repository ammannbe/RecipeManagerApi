<template>
  <rm-modal-form :title="$t('Edit cookbook')" @close="$emit('close')" @confirm="submit">
    <rm-textinput
      :label="$t('Name') + ':'"
      v-model="name"
      :placeholder="$t('Please enter name...')"
      maxlength="100"
      required
      autofocus
    />
  </rm-modal-form>
</template>

<script>
import { mapState, mapActions } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "cookbook/form/getFormFields",
  mutationType: "cookbook/form/updateFormFields"
});

export default {
  props: ["cookbook"],
  computed: {
    ...mapState({
      form: state => state.cookbooks.form.data
    }),
    ...mapFields(["name"])
  },
  created() {
    this.initForm();
    this.$autofocus();
  },
  methods: {
    ...mapActions({
      updateCookbook: "cookbooks/update"
    }),
    initForm() {
      this.name = this.cookbook.name;
    },
    async submit() {
      Object.keys(this.form).forEach(async property => {
        const value = this.form[property];

        if (this.cookbook[property] == value) {
          return;
        }

        const id = this.cookbook.id;
        this.updateCookbook({ id, property, value });
      });

      this.$emit("confirm");
      this.$emit("close");
    }
  }
};
</script>

<style>
</style>
