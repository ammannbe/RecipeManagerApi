<template>
  <form class="columns" @submit.prevent="submit" @change="form.errors.clear($event.target.name)">
    <div class="column is-one-third is-offset-3">
      <h1 class="title has-text-centered">Neues Rezept hinzufügen</h1>

      <select-field
        v-if="!$env.DISABLE_COOKBOOKS && cookbooks.length"
        :field="{
            id: 'cookbook_id',
            label: 'Kochbuch',
            icon: 'fas fa-layer-group',
            placeholder: 'Öffentlich',
            nullable: true
        }"
        :data="cookbooks"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></select-field>

      <div v-else-if="!$env.DISABLE_COOKBOOKS">
        <hr />
        <span class="has-text-weight-bold is-danger">Kein persönliches Kochbuch vorhanden!</span>
        <!-- TODO: -->
        <a href="#">Jetzt erstellen.</a>
        <hr />
      </div>

      <input-field
        :field="{
            id: 'name',
            label: 'Name',
            maxlength: '100',
            placeholder: 'Name eingeben...',
            required: true,
            icon: 'fas fa-signature'
        }"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></input-field>

      <select-field
        v-if="form.get('category_id')"
        :field="{ id: 'category_id', label: 'Kategorie', required: true, icon: 'fas fa-layer-group' }"
        :data="categories"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></select-field>

      <input-field
        :field="{
            id: 'yield_amount',
            label: 'Portionen',
            min: '1',
            max: '999',
            step: '1',
            placeholder: 'Portionen eingeben...',
            icon: 'fas fa-sort-amount-up',
            type: 'number'
        }"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></input-field>

      <select-field
        v-if="form.get('complexity')"
        :field="{ id: 'complexity', label: 'Schwierigkeitsgrad', required: true, icon: 'fas fa-signal' }"
        :data="complexities"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></select-field>

      <input-field
        :field="{ id: 'preparation_time', label: 'Zubereitungszeit (h:m)', icon: 'fas fa-clock', type: 'time' }"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></input-field>

      <multiselect-field
        v-if="!$env.DISABLE_TAGS && tags.length"
        :field="{ id: 'tags', label: 'Tags', placeholder: 'Tags auswählen...', icon: 'fas fa-tags' }"
        :data="tags"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></multiselect-field>

      <markdown-field
        :field="{
            id: 'instructions',
            label: 'Zubereitung',
            maxlength: '16000000',
            placeholder: 'Zubereitung eingeben...',
            required: true,
        }"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></markdown-field>

      <div>
        <file-field
          :key="index"
          v-for="(value, index) in fileFieldAmount"
          :field="{ id: 'photos', label: 'Fotos hochladen' }"
          :form="form"
          @select="form.replace('photos', index, $event)"
          @remove="form.remove('photos', $event)"
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
            @click.prevent="fileFieldAmount--; form.remove('photos', form.get('photos').length - 1)"
            class="field button remove"
            :disabled="fileFieldAmount <= 1"
          >
            <i class="fas fa-times"></i>
            Letztes Foto entfernen
          </button>
        </div>
      </div>

      <submit-button
        :can-cancel="true"
        @cancel="$router.go(-1)"
        :disabled="form.errors.any()"
      >Rezept hinzufügen</submit-button>
    </div>
  </form>
</template>
<script>
import Auth from "../modules/ApiClient/Auth";
import Form from "../modules/Form";
import Recipes from "../modules/ApiClient/Recipes";
import Cookbooks from "../modules/ApiClient/Cookbooks";
import Categories from "../modules/ApiClient/Categories";
import Tags from "../modules/ApiClient/Tags";
import Complexities from "../modules/ApiClient/Complexities";

export default {
  data() {
    return {
      form: new Form({
        cookbook_id: null,
        name: null,
        category_id: null,
        tags: [],
        yield_amount: 4,
        complexity: null,
        preparation_time: "00:30",
        instructions: null,
        photos: []
      }),
      cookbooks: [],
      categories: [],
      tags: [],
      complexities: [],

      fileFieldAmount: 1
    };
  },
  beforeMount() {
    if (!this.$Laravel.isLoggedIn) {
      this.$router.push({ name: "home" });
    }
  },
  mounted() {
    this.$autofocus();
    this.fetch();
  },
  methods: {
    async fetch() {
      if (!this.$env.DISABLE_COOKBOOKS) {
        this.cookbooks = await new Cookbooks().index();
      }
      this.categories = await new Categories().index();
      this.form.set("category_id", this.categories[0].id);
      if (!this.$env.DISABLE_TAGS) {
        this.tags = await new Tags().index();
      }
      this.complexities = await new Complexities().index();
      this.form.set("complexity", this.complexities[0].id);
    },
    submit() {
      this.form
        .submit(data => new Recipes().store(data), true)
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
