<template>
  <form class="columns" @submit.prevent="submit" @change="$store.commit('form/errors/reset')">
    <div class="column is-one-third is-offset-3">
      <h1 class="title has-text-centered">Anmelden</h1>

      <input-field
        name="email"
        label="E-Mail"
        placeholder="E-Mail-Adresse eingeben..."
        icon="fas fa-envelope"
        type="email"
        required
        autofocus
      ></input-field>

      <input-field
        name="password"
        label="Passwort"
        placeholder="Passwort eingeben..."
        required="true"
        icon="fas fa-key"
        type="password"
      ></input-field>

      <submit-button>Login</submit-button>
    </div>
  </form>
</template>
<script>
import Auth from "../modules/ApiClient/Auth";

export default {
  created() {
    this.$store.commit("form/set", {
      data: {
        email: "",
        password: ""
      }
    });
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
      this.$store
        .dispatch("form/submit", {
          func: data => new Auth().login(data)
        })
        .then(() => {
          this.$router.push({ name: "home" });
          location.reload();
        });
    }
  }
};
</script>
