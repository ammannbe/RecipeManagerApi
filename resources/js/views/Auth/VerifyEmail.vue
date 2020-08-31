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
    if (!this.loggedIn) {
      this.$router.push({ name: "home" });
    } else if (this.user.has_verified_email) {
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
