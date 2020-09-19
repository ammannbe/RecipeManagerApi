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
import { mapState, mapGetters } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "user/login/form/getFormFields",
  mutationType: "user/login/form/updateFormFields"
});

export default {
  computed: {
    ...mapState({
      form: state => state.user.login.form.data,
      errors: state => state.user.login.form.errors
    }),
    ...mapGetters({
      loggedIn: "user/loggedIn"
    }),
    ...mapFields(["email", "password"])
  },
  created() {
    if (this.loggedIn) {
      this.$router.push({ name: "home" });
    }
  },
  mounted() {
    this.$autofocus();
  },
  methods: {
    async submit() {
      try {
        await this.$store.dispatch("user/login", { data: this.form });
        this.$router.go(-1);
      } catch (error) {}
    }
  }
};
</script>
