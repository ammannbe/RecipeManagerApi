<template>
  <form class="columns" @submit.prevent="submit" @change="form.errors.clear($event.target.name)">
    <div class="column is-one-third is-offset-3">
      <h1 class="title has-text-centered">Anmelden</h1>

      <input-field label="E-Mail" name="email" required :errors="form.errors.get('email')">
        <template v-slot:input>
          <input
            v-model="form._data.email"
            name="email"
            class="input"
            type="email"
            placeholder="E-Mail-Adresse eingeben..."
            required
            autofocus
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
          />
        </template>
        <template v-slot:icon>
          <i class="fas fa-key"></i>
        </template>
      </input-field>

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
    if (Auth.isValid()) {
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
        .then(() => this.$router.go({ name: "home" }));
    }
  }
};
</script>
