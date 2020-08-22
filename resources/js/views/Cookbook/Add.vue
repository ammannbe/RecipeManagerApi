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
import { mapState } from "vuex";

export default {
  computed: {
    ...mapState({
      form: state => state.cookbook.form.data
    }),
    name: {
      get() {
        return this.form.name;
      },
      set(value) {
        this.updateFormProperty("name", value);
      }
    }
  },
  beforeCreate() {
    if (!this.$Laravel.isLoggedIn) {
      this.$router.push({ name: "home" });
    } else if (!this.$Laravel.hasVerifiedEmail) {
      this.$router.push({ name: "verify.email" });
    }
  },
  created() {
    this.$store.commit("cookbook/form/set", { data: { name: null } });
  },
  mounted() {
    this.$autofocus();
  },
  methods: {
    updateFormProperty(property, value) {
      this.$store.dispatch("cookbook/form/update", { property, value });
    },
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
