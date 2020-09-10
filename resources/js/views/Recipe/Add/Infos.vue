<template>
  <div
    class="column is-full-mobile is-full-tablet is-three-fifths-desktop is-offset-one-fifth-desktop"
  >
    <h1 class="title has-text-centered">{{ $t('Infos') }}</h1>

    <form @submit.prevent="$emit('input', form); $emit('next')">
      <rm-textinput
        :label="$t('Name') + ':'"
        horizontal
        v-model="form.name"
        :placeholder="$t('Please enter...')"
        required
        autofocus
      />

      <rm-select
        :label="$t('Cookbook') + ':'"
        :label-tooltip="$t('Recipes in a cookbook are not public visible.')"
        horizontal
        v-model="form.cookbook_id"
        :options="[{ id: null, name: 'Öffentlich' }, ...cookbooks]"
      />

      <rm-select
        :label="$t('Category') + ':'"
        horizontal
        v-model="form.category_id"
        :placeholder="$t('Please choose...')"
        :options="categories"
        required
      />

      <rm-numberinput
        :label="$t('Yield amount') + ':'"
        horizontal
        v-model="form.yield_amount"
        :min="0"
        :max="999"
        :step="1"
      />

      <rm-select
        :label="$t('Complexity') + ':'"
        horizontal
        v-model="form.complexity"
        :placeholder="$t('Please choose...')"
        :options="complexities"
        required
      />

      <rm-timepicker
        :label="$t('Preparation time') + ':'"
        horizontal
        v-model="form.preparation_time"
        :placeholder="$t('Please choose...')"
      />

      <rm-multiselect
        v-if="!$env.DISABLE_TAGS"
        :label="$t('Tags') + ':'"
        horizontal
        v-model="form.tags"
        :placeholder="$t('Please choose...')"
        :options="tags"
      />

      <rm-submit-button>
        Weiter
        <template v-slot:buttons>
          <b-button type="is-danger" @click="$router.go(-1)">Abbrechen</b-button>
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
