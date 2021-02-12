<template>
  <rm-modal-form
    :title="title"
    :errors="errors"
    @close="$emit('close')"
    @submit.prevent="submit"
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

    <br />
  </rm-modal-form>
</template>

<script>
import { mapState } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "categories/form/getFormFields",
  mutationType: "categories/form/updateFormFields"
});

export default {
  props: ["params"],
  computed: {
    ...mapState({
      form: state => state.categories.form.data,
      errors: state => state.categories.form.errors
    }),
    ...mapFields(["id", "name"]),
    title() {
      if (this.id) {
        return this.$t("Edit category");
      }

      return this.$t("Add category");
    }
  },
  created() {
    if (this.params) {
      ({ id: this.id, name: this.name } = this.params);
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
    async update(id, data) {
      let changed = {};
      Object.keys(data).forEach(property => {
        if (this.params[property] != data[property]) {
          changed[property] = data[property];
        }
      });

      if (Object.keys(changed).length) {
        await this.$store.dispatch("categories/update", {
          id: this.id,
          data: changed
        });
      }
    },
    async store(data) {
      await this.$store.dispatch("categories/store", { data });
    }
  }
};
</script>
