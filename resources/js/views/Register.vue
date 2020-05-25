<template>
  <form class="columns" @submit.prevent="submit" @keypress="form.errors.clear($event.target.name)">
    <div class="column is-one-third is-offset-3">
      <h1 class="title has-text-centered">Registrieren</h1>

      <input-field
        :field="{
            id: 'name',
            label: 'Name',
            placeholder: 'Name eingeben...',
            required: true,
            autofocus: true,
            icon: 'fas fa-user',
        }"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></input-field>

      <input-field
        :field="{
            id: 'email',
            label: 'E-Mail',
            placeholder: 'E-Mail-Adresse eingeben...',
            required: true,
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

      <input-field
        :field="{
            id: 'password_confirmation',
            label: 'Passwort',
            placeholder: 'Passwort bestätigen...',
            required: true,
            icon: 'fas fa-key',
            type: 'password'
        }"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></input-field>

      <submit-button :disabled="form.errors.any()">Registrieren</submit-button>
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
        name: "",
        email: "",
        password: "",
        password_confirmation: ""
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
        .submit(async data => {
          await new Auth().register(data);
          await new Auth().login({
            email: data.email,
            password: data.password
          });
        })
        .then(() => {
          this.$router.push({ name: "email.verify" });
          location.reload();
        });
    }
  }
};
</script>
