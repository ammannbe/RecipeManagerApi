<template>
  <form class="columns" @submit.prevent="submit">
    <div class="column is-one-third is-offset-3">
      <rm-emailinput
        :value="email"
        :label="$t('Email') + ':'"
        name="email"
        horizontal
        :placeholder="$t('Enter email...')"
        :message="errors.email"
        required
        disabled
      />

      <rm-passwordinput
        v-model="password"
        :label="$t('New Password') + ':'"
        name="password"
        horizontal
        :placeholder="$t('Enter password...')"
        :message="errors.password"
        required
        autofocus
      />

      <rm-passwordinput
        v-model="password_confirmation"
        :label="$t('Confirm new password') + ':'"
        name="password_confirmation"
        horizontal
        :placeholder="$t('Confirm password...')"
        :message="errors.password_confirmation"
        required
      />

      <rm-submit-button>{{ $t('Save password') }}</rm-submit-button>
    </div>
  </form>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "user/password/form/getFormFields",
  mutationType: "user/password/form/updateFormFields"
});

export default {
  props: ["params"],
  computed: {
    ...mapState({
      form: state => state.user.password.form.data,
      errors: state => state.user.password.form.errors
    }),
    ...mapGetters({
      loggedIn: "user/loggedIn"
    }),
    ...mapFields(["token", "email", "password", "password_confirmation"])
  },
  created() {
    if (this.loggedIn) {
      this.$router.push({ name: "home" });
    }

    this.token = this.params.token;
    this.email = this.params.email;
  },
  mounted() {
    this.$autofocus();
  },
  methods: {
    submit() {
      this.$store.dispatch("user/password/reset", this.form).then(() => {
        const message = "Ihr Passwort wurde erfolgreich zurück gesetzt.";
        this.$buefy.snackbar.open(message);
        this.$router.push({ name: "login" });
      });
    }
  }
};
</script>
