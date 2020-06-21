<template>
  <div>
    <form
      v-if="canEdit && isEditing"
      @submit.prevent="submit"
      @change="$store.commit('form/errors/clear', { property: $event.target.name })"
    >
      <input-field name="name" fieldClass="input title has-text-centered" required autofocus></input-field>

      <submit-button v-if="canEdit && isEditing" :can-cancel="true" @cancel="edit(false)">Speichern</submit-button>
    </form>

    <h1
      v-else
      @click="edit(!isEditing)"
      :class="{'title has-text-centered': true, 'can-edit': canEdit}"
      :title="title"
    >{{ recipeName }}</h1>
  </div>
</template>

<script>
import Recipes from "../../modules/ApiClient/Recipes";
import { mapState } from "vuex";

export default {
  props: ["recipeId", "recipeName", "canEdit"],
  data() {
    return {
      isEditing: false
    };
  },
  computed: {
    ...mapState({
      form: state => state.form.data
    }),
    title() {
      if (this.canEdit) {
        return "Klicken zum Bearbeiten";
      }
      return "";
    }
  },
  methods: {
    submit() {
      this.$store
        .dispatch("form/submit", {
          func: () =>
            new Recipes().update(this.recipeId, "name", this.form.name)
        })
        .then(() => {
          this.edit(false);
          this.$emit("update");
        });
    },
    edit(edit) {
      if (edit) {
        const data = { name: this.recipeName };
        this.$store.commit("form/set", { data });
      }
      this.isEditing = edit;
    }
  }
};
</script>

<style lang="scss" scoped>
.can-edit {
  cursor: pointer;
}
</style>
