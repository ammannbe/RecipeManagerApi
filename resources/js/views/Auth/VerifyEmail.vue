<template>
  <div class="content">
    <div
      class="box column is-one-third"
    >{{ $t('Please verify your email address, before you proceed.') }}</div>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";

export default {
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
