<template>
  <form class="columns" @submit.prevent="submit">
    <div class="column is-one-third is-offset-3">
      <h1 class="title is-3">{{ $t('Reset password') }}</h1>
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

      <rm-submit-button>{{ $t('Send') }}</rm-submit-button>
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
  computed: {
    ...mapState({
      form: state => state.user.password.form.data,
      errors: state => state.user.password.form.errors
    }),
    ...mapGetters({
      loggedIn: "user/loggedIn"
    }),
    ...mapFields(["email"])
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
    submit() {
      this.$store.dispatch("user/password/forgot", this.form).then(response => {
        this.$buefy.snackbar.open("We've sent you a link per email.");
        this.$router.push({ name: "login" });
      });
    }
  }
};
</script>
