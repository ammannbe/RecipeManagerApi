<template>
  <form class="columns" @submit.prevent="submit">
    <div class="column is-one-third is-offset-3">
      <h1 class="title has-text-centered">{{ $t('Signup') }}</h1>

      <br />

      <rm-textinput
        v-model="name"
        :label="$t('Name') + ':'"
        name="name"
        horizontal
        placeholder="eingeben..."
        :message="errors.name"
        required
        autofocus
      />

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

      <rm-passwordinput
        v-model="password_confirmation"
        :label="$t('Confirm password') + ':'"
        name="password_confirmation"
        horizontal
        :placeholder="$t('Confirm password...')"
        :message="errors.password_confirmation"
        required
      />

      <rm-submit-button>{{ $t('Signup') }}</rm-submit-button>
    </div>
  </form>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "user/register/form/getFormFields",
  mutationType: "user/register/form/updateFormFields"
});

export default {
  computed: {
    ...mapState({
      form: state => state.user.register.form.data,
      errors: state => state.user.register.form.errors
    }),
    ...mapGetters({
      loggedIn: "user/loggedIn"
    }),
    ...mapFields(["name", "email", "password", "password_confirmation"])
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
      this.$store.dispatch("user/register", { data: this.form }).then(() => {
        this.$router.push({ name: "email.verify" });
        location.reload();
      });
    }
  }
};
</script>
