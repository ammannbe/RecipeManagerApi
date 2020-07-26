<template>
  <form class="columns" @submit.prevent="submit">
    <div class="column is-one-third is-offset-3">
      <rm-emailinput
        :value="email"
        label="E-Mail:"
        name="email"
        horizontal
        placeholder="E-Mail eingeben..."
        :message="errors.email"
        required
        disabled
      />

      <rm-passwordinput
        v-model="password"
        label="Neues Passwort:"
        name="password"
        horizontal
        placeholder="Passwort eingeben..."
        :message="errors.password"
        required
        autofocus
      />

      <rm-passwordinput
        v-model="password_confirmation"
        label="Neues Passwort bestätigen:"
        name="password_confirmation"
        horizontal
        placeholder="Passwort erneut eingeben..."
        :message="errors.password_confirmation"
        required
      />

      <rm-submit-button>Neues Passwort setzen</rm-submit-button>
    </div>
  </form>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: ["token"],
  computed: {
    ...mapState({
      form: state => state.user.password.form.data,
      errors: state => state.user.password.form.errors.data
    }),
    email() {
      return this.$route.query.email;
    },
    password: {
      get() {
        return this.form.password;
      },
      set(value) {
        this.updateFormProperty("password", value);
      }
    },
    password_confirmation: {
      get() {
        return this.form.password_confirmation;
      },
      set(value) {
        this.updateFormProperty("password_confirmation", value);
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
        token: this.token,
        email: this.$route.query.email,
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
      this.$store.dispatch("user/password/reset", this.form).then(() => {
        alert("Ihr Passwort wurde erfolgreich zurück gesetzt.");
        this.$router.push({ name: "login" });
      });
    }
  }
};
</script>
