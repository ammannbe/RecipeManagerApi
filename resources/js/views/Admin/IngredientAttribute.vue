<template>
  <rm-modal-form
    :title="title"
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
  props: ["params"],
  computed: {
    ...mapState({
      form: state => state.ingredient_attributes.form.data,
      errors: state => state.ingredient_attributes.form.errors
    }),
    ...mapFields(["name"]),
    title() {
      if (this.id) {
        return this.$t("Edit ingredient attribute");
      }

      return this.$t("Add ingredient attribute");
    }
  },
  created() {
    if (this.params) {
      this.id = this.params.id;
      this.name = this.params.name;
    }
  },
  destroyed() {
    this.id = null;
    this.name = null;
  },
  methods: {
    async submit() {
      const data = this.form;

      if (this.id) {
        await this.update(this.id, data);
      } else {
        await this.store(data);
      }

      this.$emit("confirm");
      this.$emit("close");
    },
    async update(data) {
      let changed = {};
      Object.keys(data).forEach(property => {
        if (this.params[property] != data[property]) {
          changed[property] = data[property];
        }
      });

      if (Object.keys(changed).length) {
        await this.$store.dispatch("ingredient_attributes/update", {
          id: this.id,
          data: changed
        });
      }
    },
    async store(data) {
      await this.$store.dispatch("ingredient_attributes/store", { data });
    }
  }
};
</script>
