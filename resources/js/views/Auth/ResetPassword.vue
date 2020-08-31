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

export default {
  props: ["token"],
  computed: {
    ...mapState({
      form: state => state.user.password.form.data,
      errors: state => state.user.password.form.errors.data
    }),
    ...mapGetters({
      loggedIn: "user/loggedIn"
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
  created() {
    if (this.loggedIn) {
      this.$router.push({ name: "home" });
    }

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
