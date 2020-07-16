<template>
  <div>
    <form v-if="editmode.editing" @submit.prevent="$emit('update')">
      <rm-textinput id="recipe-title" v-model="name" :message="errors.name" required autofocus></rm-textinput>

      <rm-submit-button>
        Speichern
        <template v-slot:buttons>
          <b-button
            @click="$store.commit('recipe/editmode/edit', { editing: false })"
            type="is-danger"
          >Abbrechen</b-button>
        </template>
      </rm-submit-button>
    </form>

    <h1
      v-else
      @click="$store.commit('recipe/editmode/edit', { editing: !editmode.editing })"
      :class="{'title has-text-centered': true, 'can-edit': editmode.enabled}"
      :title="title"
    >{{ recipe | name }}</h1>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  computed: {
    ...mapState({
      editmode: state => state.recipe.editmode.data,
      form: state => state.recipe.form.data,
      recipe: state => state.recipe.data,
      errors: state => state.recipe.form.errors.data
    }),
    name: {
      get() {
        return this.form.name;
      },
      set(value) {
        const property = "name";
        this.$store.dispatch("recipe/form/update", { property, value });
      }
    },
    title() {
      if (this.editmode.enabled) {
        return "Klicken zum Bearbeiten";
      }
      return "";
    }
  }
};
</script>

<style lang="scss" scoped>
.can-edit {
  cursor: pointer;
}
</style>

<style lang="scss">
#recipe-title > div > input {
  text-align: center;
}
</style>
