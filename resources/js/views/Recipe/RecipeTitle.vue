<template>
  <div>
    <form v-if="editmode.editing" @submit.prevent="$emit('update')">
      <rm-textinput
        id="recipe-title"
        :inline-style="null"
        v-model="name"
        :message="errors.name"
        required
        autofocus
      ></rm-textinput>

      <rm-submit-button>
        {{ $t('Save') }}
        <template v-slot:buttons>
          <b-button
            @click="$store.dispatch('recipe/editmode/edit', { editing: false })"
            type="is-danger"
          >{{ $t('Cancel') }}</b-button>
        </template>
      </rm-submit-button>
    </form>

    <h1
      v-else
      @click="$store.dispatch('recipe/editmode/edit', { editing: !editmode.editing })"
      :class="{'title has-text-centered': true, 'can-edit': editmode.enabled}"
      :title="title"
    >{{ recipe | name }}</h1>
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
      form: state => state.recipe.form.data,
      recipe: state => state.recipe.data,
      errors: state => state.recipe.form.errors
    }),
    ...mapFields(["name"]),
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
h1 {
  margin-bottom: 4px;
}

form {
  display: flex;
  justify-content: center;
}

.can-edit {
  cursor: pointer;
}
</style>

<style lang="scss">
#recipe-title {
  margin-bottom: 0;
  margin-right: 7px;

  > div > input {
    text-align: center;
    color: #363636;
    font-size: 1rem;
    font-weight: 600;
    line-height: 1.125;
  }
}
</style>
