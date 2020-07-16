<template>
  <div class="column">
    <h1 class="title has-text-centered">Zubereitung</h1>

    <form @submit.prevent="$emit('input', form); $emit('next')">
      <rm-markdown
        v-model="form.instructions"
        placeholder="Bitte eingeben..."
        required
        autofocus
        @save="$emit('input', form); $emit('next')"
      />

      <rm-submit-button>
        Weiter
        <template v-slot:buttons>
          <b-button @click="$emit('back')" type="is-danger">Zurück</b-button>
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
        instructions: ""
      }
    };
  }
};
</script>

<style>
</style>
