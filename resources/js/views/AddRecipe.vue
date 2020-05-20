<template>
  <form class="columns" @submit.prevent="submit" @change="form.errors.clear($event.target.name)">
    <div class="column is-one-third is-offset-3">
      <h1 class="title has-text-centered">Neues Rezept hinzufügen</h1>

      <div v-if="!$env.DISABLE_COOKBOOKS">
        <input-field
          v-if="cookbooks.length"
          label="Kochbuch"
          name="cookbook_id"
          required
          :errors="form.errors.get('cookbook_id')"
        >
          <template v-slot:input>
            <div class="select">
              <select v-model="form._data.cookbook_id" name="cookbook_id" required>
                <option
                  :key="cookbook.id"
                  v-for="cookbook in cookbooks"
                  :value="cookbook.id"
                >{{ cookbook.name }}</option>
              </select>
            </div>
          </template>
          <template v-slot:icon>
            <i class="fas fa-layer-group"></i>
          </template>
        </input-field>

        <div v-else>
          <hr />
          <span class="has-text-weight-bold is-danger">Kein persönliches Kochbuch vorhanden!</span>
          <a href="#">Jetzt erstellen.</a>
          <hr />
        </div>
      </div>

      <input-field label="Name" name="name" required :errors="form.errors.get('name')">
        <template v-slot:input>
          <input
            v-model="form._data.name"
            name="name"
            class="input"
            type="string"
            maxlength="100"
            placeholder="Name eingeben..."
            required
            autofocus
          />
        </template>
        <template v-slot:icon>
          <i class="fas fa-signature"></i>
        </template>
      </input-field>

      <input-field
        label="Kategorie"
        name="category_id"
        required
        :errors="form.errors.get('category_id')"
      >
        <template v-slot:input>
          <div class="select">
            <select v-model="form._data.category_id" name="category_id" required>
              <option
                :key="category.id"
                v-for="category in categories"
                :value="category.id"
              >{{ category.name }}</option>
            </select>
          </div>
        </template>
        <template v-slot:icon>
          <i class="fas fa-layer-group"></i>
        </template>
      </input-field>

      <input-field
        v-if="!$env.DISABLE_TAGS && tags.length"
        label="Tags"
        name="tags"
        :errors="form.errors.get('tags')"
      >
        <template v-slot:input>
          <multiselect
            v-model="form._data.tags"
            :options="tags"
            :multiple="true"
            :close-on-select="false"
            track-by="id"
            placeholder="Tags auswählen"
            label="name"
          ></multiselect>
        </template>
        <template v-slot:icon>
          <i class="fas fa-tags"></i>
        </template>
      </input-field>

      <input-field label="Portionen" name="yield_amount" :errors="form.errors.get('yield_amount')">
        <template v-slot:input>
          <input
            v-model="form._data.yield_amount"
            name="yield_amount"
            class="input"
            type="number"
            min="1"
            max="999"
            step="1"
            placeholder="Portionen eingeben..."
            required
          />
        </template>
        <template v-slot:icon>
          <i class="fas fa-sort-amount-up"></i>
        </template>
      </input-field>

      <input-field
        label="Schwierigkeitsgrad"
        name="complexity"
        :errors="form.errors.get('complexity')"
      >
        <template v-slot:input>
          <div class="select">
            <select v-model="form._data.complexity" name="complexity">
              <option
                :key="complexity.id"
                v-for="complexity in complexities"
                :value="complexity.id"
              >{{ complexity.name }}</option>
            </select>
          </div>
        </template>
        <template v-slot:icon>
          <i class="fas fa-signal"></i>
        </template>
      </input-field>

      <input-field
        label="Zubereitungszeit (h:m)"
        name="preparation_time"
        :errors="form.errors.get('preparation_time')"
      >
        <template v-slot:input>
          <input
            v-model="form._data.preparation_time"
            name="preparation_time"
            class="input"
            type="time"
            placeholder="Zubereitungszeit eingeben..."
          />
        </template>
        <template v-slot:icon>
          <i class="fas fa-clock"></i>
        </template>
      </input-field>

      <input-field
        label="Zubereitung"
        name="instructions"
        :errors="form.errors.get('instructions')"
      >
        <template v-slot:input>
          <textarea
            cols="30"
            rows="10"
            v-model="form._data.instructions"
            name="instructions"
            class="input"
            type="text"
            maxlength="16000000"
            placeholder="Zubereitung eingeben..."
            required
          ></textarea>
        </template>
        <template v-slot:icon>
          <i class="fas fa-file-alt"></i>
        </template>
      </input-field>

      <div>
        <label class="label">Fotos</label>
        <file-field
          :key="index"
          v-for="(value, index) in fileFieldAmount"
          label="Foto hochladen"
          name="photos"
          :errors="form.errors.get('photos')"
          v-bind:file.sync="form._data.photos[index]"
        ></file-field>
        <!-- @selected="fileSelected(index, $event)" -->

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
            @click.prevent="fileFieldAmount--; form._data.photos[form._data.photos.length - 1] = null"
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
    if (!Auth.isValid()) {
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
      this.form._data.category_id = this.categories[0].id;
      if (!this.$env.DISABLE_TAGS) {
        this.tags = await new Tags().index();
      }
      this.complexities = await new Complexities().index();
      this.form._data.complexity = this.complexities[0].id;
    },
    submit() {
      this.form
        .submit(data => new Recipes().store(data))
        .then(() => this.$router.go({ name: "home" }));
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
