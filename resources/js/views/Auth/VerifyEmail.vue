<template>
  <div class="pb-6 mb-6">
    <h1 class="title has-text-centered">{{ $t("Verify Email Address") }}</h1>
    <div class="columns">
      <div class="column is-12 is-offset-4">
        {{ $t("Please verify your email address, before you proceed.") }}
      </div>
    </div>

    <div class="columns">
      <div class="column is-12 is-offset-4">
        <rm-button type="is-primary" @click="resend">
          {{ $t("Send verification email again") }}
        </rm-button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import Auth from "../../modules/ApiClient/Auth";

export default {
  props: ["url"],
  computed: {
    ...mapState({
      user: state => state.user.data
    }),
    ...mapGetters({
      loggedIn: "user/loggedIn"
    })
  },
  created() {
    setTimeout(() => {
      if (this.user.has_verified_email) {
        this.$buefy.snackbar.open("Your email address is already verified.");
        this.$router.push({ name: "home" });
      }
    }, 200);

    if (!this.loggedIn) {
      this.$router.push({ name: "home" });
    }

    if (this.url) {
      this.verifyEmail(this.url);
    }
  },
  methods: {
    resend() {
      new Auth().resendVerificationEmail();
    },
    async verifyEmail(url) {
      await new Auth().verifyEmail(url);
      this.$buefy.snackbar.open(
        "Your email address was successfully verified."
      );
      this.$router.push({ name: "home" });
    }
  }
};
</script>

<style lang="scss" scoped>
.content {
  display: flex;
  justify-content: center;

  > .box {
    text-align: center;
  }
}
</style>
