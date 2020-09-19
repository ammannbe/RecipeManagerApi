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
  props: ["params"],
  computed: {
    ...mapState({
      form: state => state.tags.form.data,
      errors: state => state.tags.form.errors
    }),
    ...mapFields(["name"]),
    title() {
      if (this.id) {
        return this.$t("Edit tag");
      }

      return this.$t("Add tag");
    }
  },
  created() {
    if (this.params) {
      ({ id: this.id, name: this.name } = this.params);
    }
  },
  destroyed() {
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
        await this.$store.dispatch("tags/update", {
          id: this.id,
          data: changed
        });
      }
    },
    async store(data) {
      await this.$store.dispatch("tags/store", { data });
    }
  }
};
</script>
