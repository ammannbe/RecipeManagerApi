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
              :placeholder="$t('Search...')"
              v-model="search"
            />
            <button class="button is-link is-rounded">
              <i class="fas fa-search"></i>
            </button>
          </form>
        </div>

        <div v-if="!loggedIn" class="navbar-end">
          <div class="navbar-item lang" v-for="(locale, i) in $env.LOCALES" :key="i">
            <a
              :class="{'disabled': $i18n.locale == locale}"
              @click="switchLanguage(locale)"
            >{{ locale.toUpperCase() }}</a>
          </div>
          <div v-if="!$env.DISABLE_REGISTRATION" class="navbar-item">
            <router-link :to="{ name: 'register' }" class="button">
              <span class="icon is-small">
                <i class="fas fa-sign-in-alt"></i>
              </span>
              <span>{{ $t('Signup') }}</span>
            </router-link>
          </div>
          <div class="navbar-item">
            <router-link :to="{ name: 'login' }" class="button is-primary">
              <span class="icon is-small">
                <i class="fas fa-sign-in-alt"></i>
              </span>
              <span>{{ $t('Login') }}</span>
            </router-link>
          </div>
        </div>
        <div v-else class="navbar-end">
          <div class="navbar-item lang" v-for="(locale, i) in $env.LOCALES" :key="i">
            <a
              :class="{'disabled': $i18n.locale == locale}"
              @click="switchLanguage(locale)"
            >{{ locale.toUpperCase() }}</a>
          </div>
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
              <router-link v-if="user.admin" :to="{ name: 'admin' }">
                <span class="navbar-item">{{ $t('Administration') }}</span>
              </router-link>
              <router-link :to="{ name: 'recipes.add' }">
                <span class="navbar-item">{{ $t('Add recipe') }}</span>
              </router-link>
              <router-link :to="{ name: 'cookbooks.add' }">
                <span class="navbar-item">{{ $t('Add cookbook') }}</span>
              </router-link>
              <a class="navbar-item" @click="logout()">{{ $t('Logout') }}</a>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import Locale from "../../modules/Locale";

export default {
  data() {
    return {
      isMobileMenuExpanded: false,
      search: null
    };
  },
  computed: {
    ...mapState({
      user: state => state.user.data
    }),
    ...mapGetters({
      loggedIn: "user/loggedIn"
    })
  },
  mounted() {
    this.$store.dispatch("user/show");
    this.search = this.$route.query.search;
  },
  methods: {
    expandMobileMenu() {
      this.isMobileMenuExpanded = !this.isMobileMenuExpanded;
    },
    switchLanguage(locale) {
      this.$i18n.locale = locale;
      Locale.set(locale);
    },
    async logout() {
      await this.$store.dispatch("user/logout");
      this.$router.push({ name: "home" });
    }
  }
};
</script>

<style lang="scss" scoped>
.navbar {
  z-index: 9999;

  .navbar-item.lang {
    justify-content: space-around;
  }
}

.search > button {
  margin-left: 10px;
}
</style>
