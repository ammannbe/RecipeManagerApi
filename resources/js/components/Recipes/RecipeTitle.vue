<template>
  <div>
    <form
      v-if="canEdit && isEditing"
      @submit.prevent="submit"
      @change="form.errors.clear($event.target.name)"
    >
      <input-field name="name" required :errors="form.errors.get('name')">
        <template v-slot:input>
          <input
            v-model="form._data.name"
            name="name"
            class="input title has-text-centered"
            type="text"
            required
            autofocus
          />
        </template>
      </input-field>

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
      isEditing: false
    };
  },
  watch: {
    recipe() {
      this.form._data.name = this.recipe.name;
    }
  },
  mounted() {
    this.editTitle(this.$route.query.edit_title == "true");
  },
  methods: {
    editTitle(isEditing) {
      this.isEditing = isEditing;

      if (!this.isEditing) {
        const newRouteQuery = {};
        Object.keys(this.$route.query).forEach(key => {
          if (key != "edit_title") newRouteQuery[key] = this.$route.query[key];
        });
        this.$router.push({ query: newRouteQuery });
      } else {
        const newRouteQuery = {};
        Object.keys(this.$route.query).forEach(key => {
          newRouteQuery[key] = this.$route.query[key];
        });
        newRouteQuery.edit_title = true;
        this.$router.push({ query: newRouteQuery });
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
