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
import { mapState } from "vuex";
export default {
  props: ["cookbook"],
  computed: {
    ...mapState({
      form: state => state.cookbooks.form.data
    }),
    name: {
      get() {
        return this.form.name;
      },
      set(value) {
        this.updateFormProperty("name", value);
      }
    }
  },
  created() {
    this.initForm();
    this.$autofocus();
  },
  methods: {
    initForm() {
      this.$store.commit("cookbooks/form/set", {
        data: { name: this.cookbook.name }
      });
    },
    updateFormProperty(property, value) {
      this.$store.dispatch("cookbooks/form/update", { property, value });
    },
    async submit() {
      Object.keys(this.form).forEach(async property => {
        const value = this.form[property];

        if (this.cookbook[property] == value) {
          return;
        }

        this.$store.dispatch("cookbooks/update", {
          id: this.cookbook.id,
          property,
          value
        });
      });

      this.$emit("confirm");
      this.$emit("close");
    }
  }
};
</script>

<style>
</style>
