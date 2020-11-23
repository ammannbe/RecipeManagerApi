<template>
  <div
    class="column is-full-mobile is-full-tablet is-three-fifths-desktop is-offset-one-fifth-desktop"
  >
    <h1 class="title has-text-centered">{{ $t('Infos') }}</h1>

    <form @submit.prevent="submit">
      <rm-textinput
        :label="$t('Name') + ':'"
        horizontal
        v-model="name"
        :placeholder="$t('Please enter...')"
        required
        autofocus
      />

      <rm-select
        :label="$t('Cookbook') + ':'"
        :label-tooltip="$t('Recipes in a cookbook are not public visible.')"
        horizontal
        v-model="cookbook_id"
        :options="[{ id: null, name: 'Öffentlich' }, ...cookbooks]"
      />

      <rm-select
        :label="$t('Category') + ':'"
        horizontal
        v-model="category_id"
        :placeholder="$t('Please choose...')"
        :options="categories"
        required
      />

      <rm-numberinput
        :label="$t('Yield amount') + ':'"
        horizontal
        v-model="yield_amount"
        :min="0"
        :max="999"
        :step="1"
      />

      <rm-select
        :label="$t('Complexity') + ':'"
        horizontal
        v-model="complexity"
        :placeholder="$t('Please choose...')"
        :options="complexities"
        required
      />

      <rm-timepicker
        :label="$t('Preparation time') + ':'"
        horizontal
        v-model="preparation_time"
        :placeholder="$t('Please choose...')"
      />

      <rm-multiselect
        v-if="!$env.DISABLE_TAGS && tagData && tagData.length"
        :label="$t('Tags') + ':'"
        horizontal
        v-model="tags"
        :placeholder="$t('Please choose...')"
        :options="tagData"
      />

      <rm-submit-button>
        Speichern
        <template v-slot:buttons>
          <b-button @click="$emit('back')" type="is-danger">{{ $t('Back') }}</b-button>
        </template>
      </rm-submit-button>
    </form>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "recipe/form/getFormFields",
  mutationType: "recipe/form/updateFormFields"
});

export default {
  computed: {
    ...mapState({
      form: state => state.recipe.form.data,
      errors: state => state.recipe.form.errors,
      editmode: state => state.recipe.editmode.data,
      user: state => state.user.data,
      cookbooks: state => state.cookbooks.data.data,
      categories: state => state.categories.data,
      complexities: state => state.recipe.complexities,
      tagData: state => state.tags.data
    }),
    ...mapGetters({
      loggedIn: "user/loggedIn"
    }),
    ...mapFields([
      "name",
      "cookbook_id",
      "category_id",
      "yield_amount",
      "complexity",
      "preparation_time",
      "tags",
      "instructions"
    ])
  },
  mounted() {
    setTimeout(() => {
      if (!this.loggedIn) {
        this.$router.push({ name: "home" });
      } else if (!this.user.has_verified_email) {
        this.$router.push({ name: "email.verify" });
      }
    }, 1000);

    this.instructions = this.$t('Click to edit') + '...';
    this.yield_amount = 4;
    this.complexity = this.complexities[1].id;

    this.$store.dispatch("categories/index", {});

    if (!this.$env.DISABLE_COOKBOOKS) {
      this.$store.dispatch("cookbooks/index", { limit: 1000 });
    }

    if (!this.$env.DISABLE_TAGS) {
      this.$store.dispatch("tags/index", {});
    }
  },
  methods: {
    submit() {
      this.$store.dispatch("recipe/store", { data: this.form }).then((recipe) => {
        this.edit
        this.$router.push({
          name: "recipes",
          params: { id: recipe.id, slug: recipe.slug }
        });
      });
    }
  }
};
</script>
