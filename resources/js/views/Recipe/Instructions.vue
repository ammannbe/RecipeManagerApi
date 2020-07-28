<template>
  <div :class="{'add-padding': !editmode.editing}">
    <h2
      :class="{'title is-4': true, 'can-edit': editmode.enabled}"
      @click="$store.commit('recipe/editmode/edit', { editing: !editmode.editing })"
      :title="title"
    >{{ $t('Instructions') }}</h2>

    <rm-markdown
      v-if="editmode.editing"
      v-model="instructions"
      @save="$emit('update')"
      :autofocus="false"
    ></rm-markdown>

    <div
      v-else
      :class="{'can-edit': editmode.enabled}"
      class="content"
      :title="title"
      v-html="$markdownIt.render(instructions)"
      @click="$store.commit('recipe/editmode/edit', { editing: !editmode.editing })"
    ></div>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  computed: {
    ...mapState({
      recipe: state => state.recipe.data,
      editmode: state => state.recipe.editmode.data,
      form: state => state.recipe.form.data
    }),
    instructions: {
      get() {
        return this.form.instructions;
      },
      set(value) {
        const property = "instructions";
        this.$store.dispatch("recipe/form/update", { property, value });
      }
    },
    title() {
      if (this.editmode.enabled) {
        return this.$t("Click to edit");
      }
      return "";
    }
  }
};
</script>

<style lang="scss" scoped>
div.add-padding {
  padding: 0 30px;
}

.can-edit {
  cursor: pointer;
}
</style>
