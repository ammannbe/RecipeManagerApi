<template>
  <div class="column">
    <h1 class="title has-text-centered">{{ $t('Instructions') }}</h1>

    <form @submit.prevent="$emit('input', form); $emit('next')">
      <rm-markdown
        v-model="form.instructions"
        :placeholder="$t('Please enter...')"
        required
        autofocus
        @save="$emit('input', form); $emit('next')"
      />

      <rm-submit-button>
        Weiter
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
        instructions: ""
      }
    };
  }
};
</script>
