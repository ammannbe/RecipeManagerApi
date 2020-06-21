<template>
  <form
    class="columns"
    @submit.prevent="submit"
    @change="$store.commit('form/errors/clear', { property: $event.target.name })"
  >
    <div class="column is-one-third is-offset-3">
      <h1 class="title has-text-centered">Neues Kochbuch hinzufügen</h1>

      <input-field
        name="name"
        label="Name"
        maxlength="100"
        placeholder="Name eingeben..."
        icon="fas fa-signature"
        required
      ></input-field>

      <submit-button :can-cancel="true" @cancel="$router.go(-1)">Kochbuch hinzufügen</submit-button>
    </div>
  </form>
</template>
<script>
import Cookbooks from "../modules/ApiClient/Cookbooks";

export default {
  beforeMount() {
    if (!this.$Laravel.isLoggedIn) {
      this.$router.push({ name: "home" });
    }
  },
  mounted() {
    this.$autofocus();
  },
  methods: {
    submit() {
      this.$store
        .dispatch("form/submit", {
          func: data => new Cookbooks().store(data)
        })
        .then(() => this.$router.go(-1));
    }
  }
};
</script>

<style lang="scss" scoped>
div.buttons {
  justify-content: space-around;
  align-items: start;
  margin-bottom: 10px;

  button.field > i {
    margin-right: 7px;
  }
}
</style>
