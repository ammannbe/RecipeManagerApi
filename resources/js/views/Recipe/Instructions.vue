<template>
  <div class="add-padding">
    <h2
      :class="{'title is-4': true, 'can-edit': editmode.enabled}"
      @click="$store.dispatch('recipe/editmode/edit', { editing: !editmode.editing })"
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
      @click="$store.dispatch('recipe/editmode/edit', { editing: !editmode.editing })"
    ></div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "recipe/form/getFormFields",
  mutationType: "recipe/form/updateFormFields"
});

export default {
  computed: {
    ...mapState({
      editmode: state => state.recipe.editmode.data,
      form: state => state.recipe.form.data
    }),
    ...mapFields(["instructions"]),
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

  @media screen and (max-width: 1024px) {
    padding: 0;
  }
}

.can-edit {
  cursor: pointer;
}
</style>
