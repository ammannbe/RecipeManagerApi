<template>
  <div class="content">
    <div class="box column is-one-third">Please verify your email address, before you proceed.</div>
  </div>
</template>

<script>
export default {
  beforeMount() {
    if (!this.$Laravel.isLoggedIn) {
      this.$router.push({ name: "home" });
    } else if (this.$Laravel.hasVerifiedEmail) {
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
