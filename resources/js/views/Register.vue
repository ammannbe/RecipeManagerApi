<template>
  <form class="columns" @submit.prevent="submit">
    <div class="column is-one-third is-offset-3">
      <h1 class="title has-text-centered">Registrieren</h1>

      <br />

      <rm-textinput
        v-model="name"
        label="Name:"
        name="name"
        horizontal
        placeholder="eingeben..."
        :message="errors.name"
        required
        autofocus
      />

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

      <rm-passwordinput
        v-model="password"
        label="Passwort:"
        name="password"
        horizontal
        placeholder="Passwort eingeben..."
        :message="errors.password"
        required
      />

      <rm-passwordinput
        v-model="password_confirmation"
        label="Passwort bestätigen:"
        name="password_confirmation"
        horizontal
        placeholder="Passwort erneut eingeben..."
        :message="errors.password_confirmation"
        required
      />

      <rm-submit-button>Registrieren</rm-submit-button>
    </div>
  </form>
</template>
<script>
import { mapState } from "vuex";

export default {
  computed: {
    ...mapState({
      form: state => state.user.register.form.data,
      errors: state => state.user.register.form.errors.data
    }),
    name: {
      get() {
        return this.form.name;
      },
      set(value) {
        this.updateFormProperty("name", value);
      }
    },
    email: {
      get() {
        return this.form.email;
      },
      set(value) {
        this.updateFormProperty("email", value);
      }
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
    this.$store.commit("user/register/form/set", {
      data: {
        name: null,
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
      this.$store.dispatch("user/register/form/update", { property, value });
    },
    submit() {
      this.$store.dispatch("user/register", { data: this.form }).then(() => {
        this.$router.push({ name: "email.verify" });
        location.reload();
      });
    }
  }
};
</script>
