<template>
  <form
    class="columns"
    @submit.prevent="submit"
    @change="$store.commit('form/errors/clear', { property: $event.target.name })"
  >
    <div class="column is-one-third is-offset-3">
      <h1 class="title has-text-centered">Neues Rezept hinzufügen</h1>

      <select-field
        v-if="!$env.DISABLE_COOKBOOKS && cookbooks"
        name="cookbook_id"
        label="Kochbuch"
        placeholder="Öffentlich"
        icon="fas fa-layer-group"
        nullable
        :data="cookbooks"
      ></select-field>

      <div v-else-if="!$env.DISABLE_COOKBOOKS">
        <hr />
        <span class="has-text-weight-bold is-danger">Kein persönliches Kochbuch vorhanden!</span>
        <router-link tag="a" :to="{ name: 'cookbooks-add' }">Jetzt erstellen</router-link>
        <hr />
      </div>

      <input-field
        name="name"
        label="Name"
        maxlength="100"
        placeholder="Name eingeben..."
        icon="fas fa-signature"
        required
      ></input-field>

      <select-field
        name="category_id"
        label="Kategorie"
        placeholder="Kategorie auswählen"
        icon="fas fa-layer-group"
        required
        :data="categories"
      ></select-field>

      <input-field
        name="yield_amount"
        label="Portionen"
        min="1"
        max="999"
        step="1"
        placeholder="Portionen eingeben..."
        icon="fas fa-sort-amount-up"
        type="number"
      ></input-field>

      <select-field
        name="complexity"
        label="Schwierigkeitsgrad"
        placeholder="Schwierigkeitsgrad auswählen"
        icon="fas fa-signal"
        required
        :data="complexities"
      ></select-field>

      <input-field
        name="preparation_time"
        label="Zubereitungszeit (h:m)"
        icon="fas fa-clock"
        type="time"
      ></input-field>

      <multiselect-field
        v-if="!$env.DISABLE_TAGS && tags.length"
        name="tags"
        label="Tags"
        placeholder="Tags auswählen..."
        icon="fas fa-tags"
        :data="tags"
      ></multiselect-field>

      <markdown-field
        name="instructions"
        label="Zubereitung"
        maxlength="16000000"
        placeholder="Zubereitung eingeben..."
        required
      ></markdown-field>

      <div>
        <file-field
          :key="index"
          v-for="(value, index) in fileFieldAmount"
          name="photos"
          label="Fotos hochladen"
          @select="$store.dispatch('form/update', { property: 'photos', value: $event, index})"
          @remove="$store.dispatch('form/remove', { property: 'photos', value: $event })"
        ></file-field>

        <div class="buttons">
          <button
            @click.prevent="fileFieldAmount++"
            class="field button add"
            :disabled="fileFieldAmount >= 20"
          >
            <i class="fas fa-plus"></i>
            Weiteres Foto hinzufügen
          </button>

          <button
            @click.prevent="fileFieldAmount--; $store.dispatch('form/remove', { property: 'photos', value: form.photos.length - 1 })"
            class="field button remove"
            :disabled="fileFieldAmount <= 1"
          >
            <i class="fas fa-times"></i>
            Letztes Foto entfernen
          </button>
        </div>
      </div>

      <submit-button :can-cancel="true" @cancel="$router.go(-1)">Rezept hinzufügen</submit-button>
    </div>
  </form>
</template>
<script>
import Auth from "../modules/ApiClient/Auth";
import Recipes from "../modules/ApiClient/Recipes";
import Cookbooks from "../modules/ApiClient/Cookbooks";
import Categories from "../modules/ApiClient/Categories";
import Tags from "../modules/ApiClient/Tags";
import Complexities from "../modules/ApiClient/Complexities";
import { mapState } from "vuex";

export default {
  data() {
    return {
      fileFieldAmount: 1
    };
  },
  computed: {
    ...mapState({
      form: state => state.form.data,
      tags: state => state.tag.tags,
      categories: state => state.category.categories,
      cookbooks: state => state.cookbook.cookbooks.data,
      complexities: state => state.recipe.complexities
    })
  },
  created() {
    this.$store.commit("form/set", {
      data: {
        cookbook_id: null,
        name: null,
        category_id: null,
        tags: [],
        yield_amount: 4,
        complexity: "simple",
        preparation_time: "00:30",
        instructions: "",
        photos: []
      }
    });
    if (!this.$env.DISABLE_COOKBOOKS && this.$Laravel.isLoggedIn) {
      this.$store.dispatch("cookbook/index", { limit: 1000 });
    }
    this.$store.dispatch("category/index");
    if (!this.$env.DISABLE_TAGS) {
      this.$store.dispatch("tag/index");
    }
  },
  beforeMount() {
    if (!this.$Laravel.isLoggedIn) {
      this.$router.push({ name: "home" });
    }
  },
  mounted() {
    this.$autofocus();
  },
  methods: {
    submit() {
      this.$store
        .dispatch("form/submit", {
          func: data => new Recipes().store(data)
        })
        .then(() => this.$router.push({ name: "home" }));
    }
  }
};
</script>

<style lang="scss" scoped>
div.buttons {
  justify-content: space-around;
  align-items: start;
  margin-bottom: 10px;

  button.field > i {
    margin-right: 7px;
  }
}
</style>
