<template>
  <div>
    <h2
      :class="{'title is-4': true, 'can-edit': canEdit}"
      @click="editInstructions(!isEditing)"
      :title="title"
    >Zubereitung</h2>

    <div v-if="canEdit && isEditing">
      <div :class="{'control': true}">
        <mavon-editor
          :class="{'is-danger border': form.errors.any()}"
          v-model="form._data.instructions"
          language="de"
          :toolbars="toolbars"
          @change="form.errors.clear('instructions')"
          @save="submit"
        ></mavon-editor>

        <ul v-if="form.errors.any()" class="help is-danger">
          <li :key="error" v-for="error in form.errors.all()" v-text="error"></li>
        </ul>
      </div>
    </div>

    <div
      v-else
      :class="{'can-edit': canEdit}"
      class="content"
      @click="editInstructions(!isEditing)"
      title="Klicken zum bearbeiten"
      v-html="htmlInstructions"
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
      isEditing: false,
      isUpdating: false,
      title: "",

      toolbars: {
        bold: true,
        italic: true,
        header: true,
        underline: true,
        strikethrough: true,
        mark: true,
        superscript: true,
        subscript: true,
        quote: true,
        ol: true,
        ul: true,
        link: true,
        // imagelink: true,
        code: true,
        table: true,
        fullscreen: true,
        readmodel: true,
        htmlcode: true,
        help: true,
        /* 1.3.5 */
        undo: true,
        redo: true,
        trash: true,
        save: true,
        /* 1.4.2 */
        navigation: false,
        /* 2.1.8 */
        alignleft: true,
        aligncenter: true,
        alignright: true,
        /* 2.2.1 */
        subfield: true,
        preview: true
      },

      form: new Form({
        instructions: this.instructions
      })
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
      this.form._data.instructions = this.instructions;
    }
  },
  mounted() {
    this.editInstructions(this.$route.query.edit_instructions == "true");

    if (this.canEdit) {
      this.title = "Klicken zum bearbeiten";
    }
  },
  methods: {
    editInstructions(isEditing) {
      this.isEditing = isEditing;

      if (!this.isEditing) {
        const newRouteQuery = {};
        Object.keys(this.$route.query).forEach(key => {
          if (key != "edit_instructions")
            newRouteQuery[key] = this.$route.query[key];
        });
        this.$router.push({ query: newRouteQuery });
      } else {
        const newRouteQuery = {};
        Object.keys(this.$route.query).forEach(key => {
          newRouteQuery[key] = this.$route.query[key];
        });
        newRouteQuery.edit_instructions = true;
        this.$router.push({ query: newRouteQuery });
      }
    },
    submit() {
      this.isUpdating = true;

      this.form
        .submit(() =>
          new Recipes().update(
            this.recipeId,
            "instructions",
            this.form._data.instructions
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

.is-danger.border {
  border: 1px solid red;
}
</style>
