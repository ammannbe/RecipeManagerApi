<template>
  <div>
    <form
      v-if="canEdit && isEditing"
      @submit.prevent="submit"
      @change="form.errors.clear($event.target.name)"
    >
      <input-field
        :field="{
            id: 'name',
            class: 'input title has-text-centered',
            required: true,
            autofocus: true
        }"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></input-field>

      <submit-button
        v-if="canEdit && isEditing"
        :can-cancel="true"
        :disabled="form.errors.any()"
        @cancel="editTitle(false)"
      >Speichern</submit-button>
    </form>

    <h1
      v-else
      @click="editTitle(!isEditing)"
      :class="{'title has-text-centered': true, 'can-edit': canEdit}"
      :title="title"
    >{{ recipe.name }}</h1>
  </div>
</template>

<script>
import Form from "../../modules/Form";
import Recipes from "../../modules/ApiClient/Recipes";

export default {
  props: ["recipe", "canEdit"],
  data() {
    return {
      form: new Form({
        name
      }),
      isEditing: false,
      title: ""
    };
  },
  watch: {
    recipe() {
      this.form._data.name = this.recipe.name;
    },
    canEdit() {
      this.title = "";
      if (this.canEdit) {
        this.title = "Klicken zum Bearbeiten";
      }
    }
  },
  mounted() {
    this.editTitle(this.$route.query["edit[title]"] == "true");
  },
  methods: {
    editTitle(isEditing) {
      this.isEditing = isEditing;

      if (!this.isEditing) {
        let query = Object.assign({}, this.$route.query);
        delete query["edit[title]"];
        this.$router.push({ query });
      } else {
        let edit = { "edit[title]": true };
        this.$router.push({ query: { ...this.$route.query, ...edit } });
      }
    },
    submit() {
      this.form
        .submit(() =>
          new Recipes().update(this.recipe.id, "name", this.form._data.name)
        )
        .then(() => {
          this.editTitle(false);
          this.$emit("update");
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.can-edit {
  cursor: pointer;
}
</style>
