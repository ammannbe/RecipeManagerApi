<template>
  <div class="column">
    <h1 class="title has-text-centered">{{ $t('Photos') }}</h1>

    <form @submit.prevent="$emit('input', form); $emit('next')">
      <rm-file
        v-model="form.photos"
        :placeholder="$t('Please choose...')"
        accept="image/*"
        :preview="true"
        :can-crop="true"
        multiple
        drag-drop
        required
        autofocus
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
export default {
  data() {
    return {
      form: {
        photos: []
      }
    };
  }
};
</script>

<style>
</style>
