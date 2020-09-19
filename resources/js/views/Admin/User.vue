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
import { mapState, mapMutations } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "users/form/getFormFields",
  mutationType: "users/form/updateFormFields"
});

export default {
  props: ["params"],
  computed: {
    ...mapState({
      form: state => state.users.form.data,
      errors: state => state.users.form.errors
    }),
    ...mapFields(["id", "name", "email"]),
    title() {
      if (this.id) {
        return this.$t("Edit user");
      }

      return this.$t("Add user");
    }
  },
  created() {
    if (this.params) {
      ({ id: this.id, name: this.name, email: this.email } = this.params);
    }
  },
  destroyed() {
    this.id = null;
    this.name = null;
    this.email = null;
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
        await this.$store.dispatch("users/update", {
          id: this.id,
          data: changed
        });
      }
    },
    async store(data) {
      await this.$store.dispatch("users/store", { data });
    }
  }
};
</script>
