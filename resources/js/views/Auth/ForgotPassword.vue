<template>
  <form class="columns" @submit.prevent="submit">
    <div class="column is-one-third is-offset-3">
      <h1 class="title is-3">{{ $t('Reset password') }}</h1>
      <rm-emailinput
        v-model="email"
        :label="$t('E-Mail') + ':'"
        name="email"
        horizontal
        :placeholder="$t('Enter email...')"
        :message="errors.email"
        required
        autofocus
      />

      <rm-submit-button>{{ $t('Send') }}</rm-submit-button>
    </div>
  </form>
</template>

<script>
import { mapState, mapGetters } from "vuex";

export default {
  computed: {
    ...mapState({
      form: state => state.user.password.form.data,
      errors: state => state.user.password.form.errors.data
    }),
    ...mapGetters({
      loggedIn: "user/loggedIn"
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
  created() {
    if (this.loggedIn) {
      this.$router.push({ name: "home" });
    }

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
        this.$buefy.snackbar.open("We've sent you a link per email.");
        this.$router.push({ name: "login" });
      });
    }
  }
};
</script>
