<template>
  <div class="columns">
    <div class="column is-one-third">
      <h3 class="title">Details</h3>
      <span v-if="user.admin" class="tag is-info">Du bist Admin</span>
      <br />
      <table>
        <tr>
          <th>Name:</th>
          <td>{{ user.name }}</td>
        </tr>
        <tr>
          <th>E-Mail:</th>
          <td>{{ user.email }}</td>
        </tr>
        <tr>
          <th>Registriert:</th>
          <td>{{ user.created_at }}</td>
        </tr>
        <tr>
          <th>Letzte Änderung:</th>
          <td>{{ user.updated_at }}</td>
        </tr>
      </table>
    </div>
    <div class="column is-one-third">
      <h3 class="title">Deine Rezepte</h3>
      <pagination
        v-if="recipes.last_page > 1"
        position="start"
        :current-page="recipes.current_page"
        :last-page="recipes.last_page"
        @laod="fetchRecipes($event)"
      ></pagination>
      <ul>
        <li :key="recipe.id" v-for="recipe in recipes.data">
          <span v-if="!recipe.deleted_at">
            <button @click.prevent="removeRecipe(recipe.id)" class="button is-white is-small">
              <i class="fas fa-trash"></i>
            </button>
            <router-link
              tag="a"
              :to="{ name:'recipes', params: {id: recipe.id, slug: recipe.slug} }"
            >{{ recipe.name }}</router-link>
          </span>
          <span v-else>
            <button @click.prevent="restoreRecipe(recipe.id)" class="button is-white is-small">
              <i class="fas fa-redo"></i>
            </button>
            {{ recipe.name }}
          </span>
        </li>
      </ul>
    </div>
    <div class="column is-one-third">
      <h3 class="title">Deine Kochbücher</h3>
      <pagination
        v-if="cookbooks.last_page > 1"
        position="start"
        :current-page="cookbooks.current_page"
        :last-page="cookbooks.last_page"
        @laod="fetchCookbooks($event)"
      ></pagination>
      <ul>
        <li :key="cookbook.id" v-for="cookbook in cookbooks">
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
import Users from "../modules/ApiClient/Users";
import Recipes from "../modules/ApiClient/Recipes";
import Cookbooks from "../modules/ApiClient/Cookbooks";

export default {
  data() {
    return {
      user: {
        name: "-",
        email: "-",
        admin: false,
        created_at: "-",
        updated_at: "-"
      },
      recipes: {},
      cookbooks: {}
    };
  },
  beforeMount() {
    if (!this.$Laravel.isLoggedIn) {
      this.$router.push({ name: "home" });
    } else if (!this.$Laravel.hasVerifiedEmail) {
      this.$router.push({ name: "verify.email" });
    }
  },
  mounted() {
    this.fetchUser();
    this.fetchRecipes();
    this.fetchCookbooks();
  },
  methods: {
    async fetchUser() {
      this.user = await new Users().show();
    },
    async fetchRecipes(page = 1) {
      let trashed = true;
      this.recipes = await new Recipes().index({ trashed, page });
    },
    async fetchCookbooks() {
      let trashed = true;
      this.cookbooks = await new Cookbooks().index({ trashed });
    },
    async removeRecipe(recipeId) {
      await new Recipes().remove(recipeId);
      this.fetchRecipes();
    },
    async removeCookbook(cookbookId) {
      await new Cookbooks().remove(cookbookId);
      this.fetchCookbooks();
    },
    async restoreRecipe(recipeId) {
      await new Recipes().restore(recipeId);
      this.fetchRecipes();
    },
    async restoreCookbook(cookbookId) {
      await new Cookbooks().restore(cookbookId);
      this.fetchCookbooks();
    }
  }
};
</script>
<style lang="scss" scoped>
th {
  text-align: right !important;
  padding-right: 10px;
}
</style>
