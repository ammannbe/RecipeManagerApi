<template>
  <form class="columns" @submit.prevent="submit" @keypress="form.errors.clear($event.target.name)">
    <div class="column is-one-third is-offset-3">
      <h1 class="title has-text-centered">Registrieren</h1>

      <input-field label="Name" name="name" required :errors="form.errors.get('name')">
        <template v-slot:input>
          <input
            v-model="form._data.name"
            class="input"
            name="name"
            type="text"
            placeholder="Name eingeben..."
            required
            autofocus
          />
        </template>
        <template v-slot:icon>
          <i class="fas fa-user"></i>
        </template>
      </input-field>

      <input-field label="E-Mail" name="email" required :errors="form.errors.get('email')">
        <template v-slot:input>
          <input
            v-model="form._data.email"
            name="email"
            class="input"
            type="email"
            placeholder="E-Mail-Adresse eingeben..."
            required
          />
        </template>
        <template v-slot:icon>
          <i class="fas fa-envelope"></i>
        </template>
      </input-field>

      <input-field label="Passwort" name="password" required :errors="form.errors.get('password')">
        <template v-slot:input>
          <input
            v-model="form._data.password"
            name="password"
            class="input"
            type="password"
            placeholder="Passwort eingeben..."
            required
            minlength="8"
          />
        </template>
        <template v-slot:icon>
          <i class="fas fa-key"></i>
        </template>
      </input-field>

      <input-field
        label="Passwort-Bestätigung"
        name="password_confirmation"
        required
        :errors="form.errors.get('password_confirmation')"
      >
        <template v-slot:input>
          <input
            v-model="form._data.password_confirmation"
            name="password_confirmation"
            class="input"
            type="password"
            placeholder="Passwort eingeben..."
            required
            minlength="8"
          />
        </template>
        <template v-slot:icon>
          <i class="fas fa-key"></i>
        </template>
      </input-field>

      <submit-button :disabled="form.errors.any()">Registrieren</submit-button>
    </div>
  </form>
</template>
<script>
import Auth from "../modules/ApiClient/Auth";
import Errors from "../modules/Errors";
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
