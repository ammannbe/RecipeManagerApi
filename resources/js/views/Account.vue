<template>
  <div class="columns">
    <div class="column is-one-third">
      <h3 class="title">{{ $t('Details') }}</h3>

      <table>
        <tr>
          <th>{{ $t('Name') }}:</th>
          <td>{{ user.name }}</td>
        </tr>
        <tr>
          <th>{{ $t('Email') }}:</th>
          <td>{{ user.email }}</td>
        </tr>
        <tr>
          <th>{{ $t('Signed Up') }}:</th>
          <td :title="$moment(user.created_at)">{{ $moment(user.created_at).from() }}</td>
        </tr>
        <tr>
          <th>{{ $t('Last change') }}:</th>
          <td :title="$moment(user.updated_at)">{{ $moment(user.updated_at).from() }}</td>
        </tr>
        <tr>
          <span v-if="user.admin" class="tag is-info">{{ $t('You\'re admin') }}</span>
        </tr>
      </table>
    </div>
    <div class="column is-one-third">
      <h3
        @click.prevent="$router.push({ name: 'recipes.add' })"
        class="title add-cursor"
      >{{ user.admin ? $t('All recipes') : $t('Your recipes') }}</h3>
      <pagination
        v-if="recipes.last_page > 1"
        position="start"
        :current="recipes.current_page"
        :last="recipes.last_page"
        :route-name="this.$route.name"
        query-url="recipe-page"
        @load="loadRecipes"
      ></pagination>
      <ul>
        <li :key="recipe.id" v-for="recipe in sortedRecipes">
          <span v-if="!recipe.deleted_at">
            <button
              @click.prevent="$store.dispatch('recipes/remove', { id: recipe.id })"
              class="button is-white is-small"
            >
              <i class="fas fa-trash"></i>
            </button>
            <router-link
              tag="a"
              :to="{ name:'recipes', params: {id: recipe.id, slug: recipe.slug} }"
            >{{ recipe.name }}</router-link>
          </span>
          <span v-else>
            <button
              @click.prevent="$store.dispatch('recipes/restore', { id: recipe.id })"
              class="button is-white is-small"
            >
              <i class="fas fa-redo"></i>
            </button>
            {{ recipe.name }}
          </span>
        </li>
      </ul>
    </div>
    <div class="column is-one-third">
      <h3
        @click.prevent="$router.push({ name: 'cookbooks.add' })"
        class="title add-cursor"
      >{{ user.admin ? $t('All cookbooks') : $t('Your cookbooks') }}</h3>
      <ul>
        <li :key="cookbook.id" v-for="cookbook in sortedCookbooks">
          <span v-if="!cookbook.deleted_at">
            <button @click.prevent="removeCookbook(cookbook.id)" class="button is-white is-small">
              <i class="fas fa-trash"></i>
            </button>
            {{ cookbook.name }}
          </span>
          <span v-else>
            <button @click.prevent="restoreCookbook(cookbook.id)" class="button is-white is-small">
              <i class="fas fa-redo"></i>
            </button>
            {{ cookbook.name }}
          </span>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  data() {
    return {
      showAddCookbook: false,
      currentRecipePage: 1
    };
  },
  computed: {
    ...mapState({
      recipes: state => state.recipes.data,
      cookbooks: state => state.cookbooks.data,
      user: state => state.user.user
    }),
    sortedRecipes() {
      if (!this.recipes.data) {
        return this.recipes;
      }

      return this.recipes.data.sort(
        (a, b) => a.deleted_at != null && a.id > b.id
      );
    },
    sortedCookbooks() {
      if (!this.cookbooks.data) {
        return this.cookbooks;
      }

      return this.cookbooks.data.sort(
        (a, b) => a.deleted_at != null && a.id > b.id
      );
    }
  },
  beforeCreate() {
    if (!this.$Laravel.isLoggedIn) {
      this.$router.push({ name: "home" });
    } else if (!this.$Laravel.hasVerifiedEmail) {
      this.$router.push({ name: "verify.email" });
    }
  },
  mounted() {
    this.loadRecipes();
    this.$store.dispatch("cookbooks/index", { trashed: true, page: 1 });
  },
  methods: {
    loadRecipes(page = 1) {
      this.currentRecipePage = page;
      this.$store.dispatch("recipes/index", {
        trashed: true,
        only_own: !this.user.admin,
        page
      });
    },
    async removeCookbook(id) {
      await this.$store.dispatch("cookbooks/remove", { id });
      this.loadRecipes(this.currentRecipePage);
    },
    async restoreCookbook(id) {
      await this.$store.dispatch("cookbooks/restore", { id });
      this.loadRecipes(this.currentRecipePage);
    }
  }
};
</script>

<style lang="scss" scoped>
th {
  text-align: right !important;
  padding-right: 10px;
}

.add-cursor {
  cursor: copy;
}
</style>
