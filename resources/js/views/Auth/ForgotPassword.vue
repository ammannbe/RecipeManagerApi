<template>
  <form class="columns" @submit.prevent="submit">
    <div class="column is-one-third is-offset-3">
      <h1 class="title is-3">Passwort zurücksetzen</h1>
      <rm-emailinput
        v-model="email"
        label="E-Mail:"
        name="email"
        horizontal
        placeholder="E-Mail eingeben..."
        :message="errors.email"
        required
        autofocus
      />

      <rm-submit-button>Senden</rm-submit-button>
    </div>
  </form>
</template>

<script>
import { mapState } from "vuex";

export default {
  computed: {
    ...mapState({
      form: state => state.user.password.form.data,
      errors: state => state.user.password.form.errors.data
    }),
    email: {
      get() {
        return this.form.email;
      },
      set(value) {
        this.updateFormProperty("email", value);
      }
    }
  },
  beforeCreate() {
    if (this.$Laravel.isLoggedIn) {
      this.$router.push({ name: "home" });
    }
  },
  created() {
    this.$store.commit("user/password/form/set", {
      data: {
        email: null,
        password: null,
        password_confirmation: null
      }
    });
  },
  mounted() {
    this.$autofocus();
  },
  methods: {
    updateFormProperty(property, value) {
      this.$store.dispatch("user/password/form/update", { property, value });
    },
    submit() {
      this.$store.dispatch("user/password/forgot", this.form).then(response => {
        alert("Wir haben dir einen Link per E-Mail zugestellt.");
        this.$router.push({ name: "login" });
      });
    }
  }
};
</script>
