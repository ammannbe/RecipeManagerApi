<template>
  <form class="columns" @submit.prevent="submit" @change="form.errors.clear($event.target.name)">
    <div class="column is-one-third is-offset-3">
      <h1 class="title has-text-centered">Neues Kochbuch hinzufügen</h1>

      <input-field
        :field="{
            id: 'name',
            label: 'Name',
            maxlength: '100',
            placeholder: 'Name eingeben...',
            required: true,
            icon: 'fas fa-signature'
        }"
        :form="form"
        @changed="form.set($event.id, $event.value)"
      ></input-field>

      <submit-button
        :can-cancel="true"
        @cancel="$router.go(-1)"
        :disabled="form.errors.any()"
      >Kochbuch hinzufügen</submit-button>
    </div>
  </form>
</template>
<script>
import Cookbooks from "../modules/ApiClient/Cookbooks";
import Form from "../modules/Form";

export default {
  data() {
    return {
      form: new Form({
        name: ""
      })
    };
  },
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
      this.form
        .submit(data => new Cookbooks().store(data), true)
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
