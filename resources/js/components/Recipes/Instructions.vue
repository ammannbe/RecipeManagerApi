<template>
  <div>
    <h2
      :class="{'title is-4': true, 'can-edit': canEdit}"
      @click="edit(!isEditing)"
      :title="title"
    >Zubereitung</h2>

    <markdown-field v-if="canEdit && isEditing" name="instructions" @saved="submit()"></markdown-field>

    <div
      v-else
      :class="{'can-edit': canEdit}"
      class="content"
      :title="title"
      v-html="instructions"
      @click="edit(!isEditing)"
    ></div>
  </div>
</template>

<script>
import Recipes from "../../modules/ApiClient/Recipes";
import { mapState } from "vuex";

export default {
  props: ["canEdit"],
  data() {
    return {
      isEditing: false
    };
  },
  computed: {
    ...mapState({
      recipe: state => state.recipe.recipe,
      form: state => state.form.data
    }),
    instructions() {
      if (!this.recipe.instructions) {
        return "";
      }
      return this.$markdownIt.render(this.recipe.instructions);
    },
    title() {
      if (this.canEdit) {
        return "Klicken zum Bearbeiten";
      }
      return "";
    }
  },
  created() {},
  methods: {
    submit() {
      let id = this.recipe.id;
      this.$store
        .dispatch("form/submit", {
          func: data => {
            new Recipes(data).update(
              id,
              "instructions",
              this.form.instructions
            );
          }
        })
        .then(() => {
          this.$store.dispatch("recipe/show", { id });
          this.edit(false);
        });
    },
    edit(edit) {
      if (edit) {
        const data = { instructions: this.recipe.instructions };
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
