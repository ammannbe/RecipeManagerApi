<template>
  <div
    class="column is-full-mobile is-full-tablet is-three-fifths-desktop is-offset-one-fifth-desktop"
  >
    <h1 class="title has-text-centered">Informationen</h1>

    <form @submit.prevent="$emit('input', form); $emit('next')">
      <rm-textinput
        label="Name:"
        horizontal
        v-model="form.name"
        placeholder="Bitte eingeben..."
        required
        autofocus
      />

      <rm-select
        label="Kochbuch:"
        label-tooltip="Rezepte in einem Kochbuch sind nicht öffentlich einsehbar."
        horizontal
        v-model="form.cookbook_id"
        :options="[{ id: null, name: 'Öffentlich' }, ...cookbooks]"
      />

      <rm-select
        label="Kategorie:"
        horizontal
        v-model="form.category_id"
        placeholder="Bitte wählen..."
        :options="categories"
        required
      />

      <rm-numberinput
        label="Portionen:"
        horizontal
        v-model="form.yield_amount"
        :min="0"
        :max="999"
        :step="1"
      />

      <rm-select
        label="Schwierigkeitsgrad:"
        horizontal
        v-model="form.complexity"
        placeholder="Bitte wählen..."
        :options="complexities"
        required
      />

      <rm-timepicker
        label="Zubereitungszeit"
        horizontal
        v-model="form.preparation_time"
        placeholder="Bitte wählen..."
      />

      <rm-multiselect
        label="Tags:"
        horizontal
        v-model="form.tags"
        placeholder="Bitte auswählen..."
        :options="tags"
      />

      <rm-submit-button>
        Weiter
        <template v-slot:buttons>
          <b-button type="is-danger" disabled>Zurück</b-button>
        </template>
      </rm-submit-button>
    </form>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  data() {
    return {
      form: {
        cookbook_id: null,
        category_id: null,
        yield_amount: 4,
        complexity: null,
        preparation_time: "00:00",
        tags: []
      }
    };
  },
  computed: {
    ...mapState({
      cookbooks: state => state.cookbooks.data.data,
      categories: state => state.categories.data,
      complexities: state => state.recipe.complexities,
      tags: state => state.tags.data
    })
  }
};
</script>
