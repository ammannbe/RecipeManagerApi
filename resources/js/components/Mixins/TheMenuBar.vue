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
            <h1 class="title">{{ $env.APP_NAME }}</h1>
          </router-link>
        </div>
        <a
          role="button"
          class="navbar-burger"
          aria-label="menu"
          aria-expanded="false"
          @click="expandMobileMenu"
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

        <div class="navbar-end" v-if="!isLoggedIn">
          <div class="navbar-item">
            <router-link :to="{ name: 'register' }" class="button">
              <span class="icon is-small">
                <i class="fas fa-sign-in-alt"></i>
              </span>
              <span>Registrieren</span>
            </router-link>
          </div>
          <div v-if="!isLoggedIn" class="navbar-item">
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
                <span>Mein Konto</span>
              </div>
            </router-link>

            <div class="navbar-dropdown">
              <router-link :to="{ name: 'account' }">
                <span class="navbar-item">Mein Konto</span>
              </router-link>
              <router-link :to="{ name: 'recipes-add' }">
                <span class="navbar-item">Rezept hinzufügen</span>
              </router-link>
              <a class="navbar-item" @click="logout">Abmelden</a>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
import Auth from "../../modules/ApiClient/Auth";
export default {
  data() {
    return {
      isMobileMenuExpanded: false,
      search: null,
      isLoggedIn: false
    };
  },
  mounted() {
    this.search = this.$route.query.search;

    this.validateLogin();
    setInterval(() => {
      this.validateLogin();
    }, 60000);
  },
  methods: {
    validateLogin() {
      this.isLoggedIn = Auth.isValid();
    },
    expandMobileMenu() {
      this.isMobileMenuExpanded = !this.isMobileMenuExpanded;
    },
    logout() {
      new Auth().logout().then(() => {
        this.$router.push({ name: "home" });
        this.validateLogin();
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.search > button {
  margin-left: 10px;
}
</style>
