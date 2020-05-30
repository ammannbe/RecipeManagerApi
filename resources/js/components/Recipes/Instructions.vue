<template>
  <div>
    <h2
      :class="{'title is-4': true, 'can-edit': canEdit}"
      @click="editInstructions(!isEditing)"
      :title="title"
    >Zubereitung</h2>

    <markdown-field
      v-if="canEdit && isEditing"
      :field="{ id: 'instructions' }"
      :form="form"
      @changed="form.set($event.id, $event.value)"
      @saved="submit()"
    ></markdown-field>

    <div
      v-else
      :class="{'can-edit': canEdit}"
      class="content"
      :title="title"
      v-html="htmlInstructions"
      @click="editInstructions(!isEditing)"
    ></div>
  </div>
</template>

<script>
import Form from "../../modules/Form";
import Recipes from "../../modules/ApiClient/Recipes";

export default {
  props: ["recipeId", "instructions", "canEdit"],
  data() {
    return {
      form: new Form({
        instructions: this.instructions
      }),

      isEditing: false,
      isUpdating: false,
      title: ""
    };
  },
  computed: {
    htmlInstructions() {
      if (!this.instructions) {
        return "";
      }
      return this.$markdownIt.render(this.instructions);
    }
  },
  watch: {
    instructions() {
      this.form.set("instructions", this.instructions);
    },
    canEdit() {
      this.title = "";
      if (this.canEdit) {
        this.title = "Klicken zum Bearbeiten";
      }
    }
  },
  mounted() {
    this.editInstructions(this.$route.query["edit[instructions]"] == "true");
  },
  methods: {
    editInstructions(isEditing) {
      this.isEditing = isEditing;

      if (!this.isEditing) {
        let query = Object.assign({}, this.$route.query);
        delete query["edit[instructions]"];
        this.$router.push({ query });
      } else {
        let edit = { "edit[instructions]": true };
        this.$router.push({ query: { ...this.$route.query, ...edit } });
      }
    },
    submit() {
      this.isUpdating = true;

      this.form
        .submit(() =>
          new Recipes().update(
            this.recipeId,
            "instructions",
            this.form.get("instructions")
          )
        )
        .then(() => {
          this.$emit("updated");
          this.isUpdating = false;
          this.editInstructions(false);
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
