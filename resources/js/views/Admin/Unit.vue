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
  props: ["params"],
  computed: {
    ...mapState({
      form: state => state.units.form.data,
      errors: state => state.units.form.errors
    }),
    ...mapFields([
      "id",
      "name",
      "name_shortcut",
      "name_plural",
      "name_plural_shortcut"
    ]),
    title() {
      if (this.id) {
        return this.$t("Edit unit");
      }

      return this.$t("Add unit");
    }
  },
  created() {
    if (this.params) {
      ({
        id: this.id,
        name: this.name,
        name_shortcut: this.name_shortcut,
        name_plural: this.name_plural,
        name_plural_shortcut: this.name_plural_shortcut
      } = this.params);
    }
  },
  destroyed() {
    this.id = null;
    this.name = null;
    this.name_shortcut = null;
    this.name_plural = null;
    this.name_plural_shortcut = null;
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
        await this.$store.dispatch("units/update", {
          id: this.id,
          data: changed
        });
      }
    },
    async store(data) {
      await this.$store.dispatch("units/store", { data });
    }
  }
};
</script>
