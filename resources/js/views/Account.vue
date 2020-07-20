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
          <td :title="$moment(user.created_at)">{{ $moment(user.created_at).from() }}</td>
        </tr>
        <tr>
          <th>Letzte Änderung:</th>
          <td :title="$moment(user.updated_at)">{{ $moment(user.updated_at).from() }}</td>
        </tr>
      </table>
    </div>
    <div class="column is-one-third">
      <h3
        @click.prevent="$router.push({ name: 'recipes-add' })"
        class="title add-cursor"
      >Deine Rezepte</h3>
      <pagination
        v-if="recipes.last_page > 1"
        position="start"
        :current-page="recipes.current_page"
        :last-page="recipes.last_page"
        @load="$store.dispatch('recipes/index', { trashed: true, page: $event })"
      ></pagination>
      <ul>
        <li :key="recipe.id" v-for="recipe in recipes.data">
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
        @click.prevent="$router.push({ name: 'cookbooks-add' })"
        class="title add-cursor"
      >Deine Kochbücher</h3>
      <ul>
        <li :key="cookbook.id" v-for="cookbook in cookbooks.data">
          <span v-if="!cookbook.deleted_at">
            <button
              @click.prevent="$store.dispatch('cookbook/remove', { id: cookbook.id })"
              class="button is-white is-small"
            >
              <i class="fas fa-trash"></i>
            </button>
            {{ cookbook.name }}
          </span>
          <span v-else>
            <button
              @click.prevent="$store.dispatch('cookbook/restore', { id: cookbook.id })"
              class="button is-white is-small"
            >
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
      showAddCookbook: false
    };
  },
  computed: {
    ...mapState({
      recipes: state => state.recipes.data,
      cookbooks: state => state.cookbooks.data,
      user: state => state.user.user
    })
  },
  beforeCreate() {
    if (!this.$Laravel.isLoggedIn) {
      this.$router.push({ name: "home" });
    } else if (!this.$Laravel.hasVerifiedEmail) {
      this.$router.push({ name: "verify.email" });
    }
  },
  mounted() {
    this.$store.dispatch("recipes/index", { trashed: true, page: 1 });
    this.$store.dispatch("cookbooks/index", { trashed: true, page: 1 });
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
