<template>
  <div>
    <nav
      class="navbar has-shadow is-fixed-top is-spaced"
      role="navigation"
      aria-label="dropdown navigation"
    >
      <div class="navbar-brand">
        <div class="navbar-item">
          <router-link :to="{ name: 'home' }">
            <h1 @click="$emit('search')" class="title">{{ $env.APP_NAME }}</h1>
          </router-link>
        </div>
        <a
          role="button"
          class="navbar-burger"
          aria-label="menu"
          aria-expanded="false"
          @click="expandMobileMenu()"
        >
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>
      <div class="navbar-menu" v-bind:class="{ 'is-active': isMobileMenuExpanded }">
        <div class="navbar-start">
          <form class="navbar-item search" @submit.prevent="$emit('search', search)">
            <input
              type="text"
              class="input is-rounded"
              minlength="5"
              placeholder="Suchen..."
              v-model="search"
            />
            <button class="button is-link is-rounded">
              <i class="fas fa-search"></i>
            </button>
          </form>
        </div>

        <div v-if="!$Laravel.isLoggedIn" class="navbar-end">
          <div v-if="!$env.DISABLE_REGISTRATION" class="navbar-item">
            <router-link :to="{ name: 'register' }" class="button">
              <span class="icon is-small">
                <i class="fas fa-sign-in-alt"></i>
              </span>
              <span>Registrieren</span>
            </router-link>
          </div>
          <div class="navbar-item">
            <router-link :to="{ name: 'login' }" class="button is-primary">
              <span class="icon is-small">
                <i class="fas fa-sign-in-alt"></i>
              </span>
              <span>Anmelden</span>
            </router-link>
          </div>
        </div>
        <div class="navbar-end" v-else>
          <div class="navbar-item has-dropdown is-hoverable">
            <router-link :to="{ name: 'account' }">
              <div style="position:relative" class="navbar-link">
                <span class="icon">
                  <i class="fas fa-user"></i>
                </span>
                <span>{{ user.name }}</span>
              </div>
            </router-link>

            <div class="navbar-dropdown">
              <router-link :to="{ name: 'account' }">
                <span class="navbar-item">Mein Konto</span>
              </router-link>
              <router-link :to="{ name: 'recipes-add' }">
                <span class="navbar-item">Rezept hinzufügen</span>
              </router-link>
              <router-link :to="{ name: 'cookbooks-add' }">
                <span class="navbar-item">Kochbuch hinzufügen</span>
              </router-link>
              <a class="navbar-item" @click="logout()">Abmelden</a>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  data() {
    return {
      isMobileMenuExpanded: false,
      search: null
    };
  },
  computed: {
    ...mapState({
      user: state => state.user.user
    })
  },
  mounted() {
    this.search = this.$route.query.search;
  },
  methods: {
    expandMobileMenu() {
      this.isMobileMenuExpanded = !this.isMobileMenuExpanded;
    },
    logout() {
      this.$store.dispatch("user/logout").then(() => {
        this.$router.push({ name: "home" });
        this.$forceUpdate();
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.navbar {
  z-index: 9999;
}

.search > button {
  margin-left: 10px;
}
</style>
