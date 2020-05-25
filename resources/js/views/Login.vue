<template>
  <form class="columns" @submit.prevent="submit" @change="form.errors.clear()">
    <div class="column is-one-third is-offset-3">
      <h1 class="title has-text-centered">Anmelden</h1>

      <input-field
        :field="{
            id: 'email',
            label: 'E-Mail',
            placeholder: 'E-Mail-Adresse eingeben...',
            required: true,
            autofocus: true,
            icon: 'fas fa-envelope',
            type: 'email'
        }"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></input-field>

      <input-field
        :field="{
            id: 'password',
            label: 'Passwort',
            placeholder: 'Passwort eingeben...',
            required: true,
            icon: 'fas fa-key',
            type: 'password'
        }"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></input-field>

      <submit-button :disabled="form.errors.any()">Login</submit-button>
    </div>
  </form>
</template>
<script>
import Auth from "../modules/ApiClient/Auth";
import Form from "../modules/Form";

export default {
  data() {
    return {
      form: new Form({
        email: "",
        password: ""
      })
    };
  },
  beforeMount() {
    if (this.$Laravel.isLoggedIn) {
      this.$router.push({ name: "home" });
    }
  },
  mounted() {
    this.$autofocus();
  },
  methods: {
    submit() {
      this.form
        .submit(data => new Auth().login(data))
        .then(() => {
          this.$router.push({ name: "home" });
          location.reload();
        });
    }
  }
};
</script>
