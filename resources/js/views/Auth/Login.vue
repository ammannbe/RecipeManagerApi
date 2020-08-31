<template>
  <form class="columns" @submit.prevent="submit">
    <div class="column is-one-third is-offset-3">
      <h1 class="title has-text-centered">{{ $t('Login') }}</h1>

      <br />

      <rm-emailinput
        v-model="email"
        :label="$t('Email') + ':'"
        name="email"
        horizontal
        :placeholder="$t('Enter email...')"
        :message="errors.email"
        required
        autofocus
      />

      <rm-passwordinput
        v-model="password"
        :label="$t('Password') + ':'"
        name="password"
        horizontal
        :placeholder="$t('Enter password...')"
        :message="errors.password"
        required
      />

      <router-link tag="a" :to="{ name: 'password.forgot' }">{{ $t('Forgot password?') }}</router-link>

      <rm-submit-button>{{ $t('Login') }}</rm-submit-button>
    </div>
  </form>
</template>

<script>
import { mapState } from "vuex";

export default {
  computed: {
    ...mapState({
      form: state => state.user.login.form.data,
      errors: state => state.user.login.form.errors.data
    }),
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
    }
  },
  beforeCreate() {
    if (this.$Laravel.isLoggedIn) {
      this.$router.push({ name: "home" });
    }
  },
  created() {
    this.$store.commit("user/login/form/set", {
      data: { email: null, password: null }
    });
  },
  mounted() {
    this.$autofocus();
  },
  methods: {
    updateFormProperty(property, value) {
      this.$store.dispatch("user/login/form/update", { property, value });
    },
    async submit() {
      await this.$store.dispatch("user/login", { data: this.form });
      this.$router.push({ name: "home" });
    }
  }
};
</script>
