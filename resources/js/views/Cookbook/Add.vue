<template>
  <form class="columns" @submit.prevent="submit">
    <div class="column is-one-third is-offset-3">
      <h1 class="title has-text-centered">{{ $t('Add cookbook') }}</h1>

      <br />

      <rm-textinput
        :label="$t('Name') + ':'"
        horizontal
        v-model="name"
        :placeholder="$t('Please enter name...')"
        :message="errors.name"
        maxlength="100"
        required
        autofocus
      />

      <rm-submit-button>
        {{ $t('Add') }}
        <template v-slot:buttons>
          <b-button @click="$router.go(-1)" type="is-danger">{{ $t('Cancel') }}</b-button>
        </template>
      </rm-submit-button>
    </div>
  </form>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "cookbook/form/getFormFields",
  mutationType: "cookbook/form/updateFormFields"
});

export default {
  computed: {
    ...mapState({
      user: state => state.user.data,
      form: state => state.cookbook.form.data,
      errors: state => state.cookbook.form.errors
    }),
    ...mapGetters({
      loggedIn: "user/loggedIn"
    }),
    ...mapFields(["name"])
  },
  created() {
    setTimeout(() => {
      if (!this.loggedIn) {
        this.$router.push({ name: "home" });
      } else if (!this.user.has_verified_email) {
        this.$router.push({ name: "verify.email" });
      }
    }, 1000);
  },
  mounted() {
    this.$autofocus();
  },
  methods: {
    submit() {
      this.$store
        .dispatch("cookbook/store", { data: this.form })
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
