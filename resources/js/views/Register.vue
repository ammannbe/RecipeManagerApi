<template>
  <form
    class="columns"
    @submit.prevent="submit"
    @keypress="$store.commit('form/errors/clear', { property: $event.target.name })"
  >
    <div class="column is-one-third is-offset-3">
      <h1 class="title has-text-centered">Registrieren</h1>

      <input-field
        name="name"
        label="Name"
        placeholder="Name eingeben..."
        icon="fas fa-user"
        required
        autofocus
      ></input-field>

      <input-field
        name="email"
        label="E-Mail"
        placeholder="E-Mail-Adresse eingeben..."
        icon="fas fa-envelope"
        type="email"
        required
      ></input-field>

      <input-field
        name="password"
        label="Passwort"
        placeholder="Passwort eingeben..."
        icon="fas fa-key"
        type="password"
        required
      ></input-field>

      <input-field
        name="password_confirmation"
        label="Passwort"
        placeholder="Passwort bestätigen..."
        icon="fas fa-key"
        type="password"
        required
      ></input-field>

      <submit-button>Registrieren</submit-button>
    </div>
  </form>
</template>
<script>
import Auth from "../modules/ApiClient/Auth";

export default {
  created() {
    this.$store.commit("form/set", {
      data: {
        name: "",
        email: "",
        password: "",
        password_confirmation: ""
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
          func: async data => {
            await new Auth().register(data);
            await new Auth().login({
              email: data.email,
              password: data.password
            });
          }
        })
        .then(() => {
          this.$router.push({ name: "email.verify" });
          this.$forceUpdate();
        });
    }
  }
};
</script>
