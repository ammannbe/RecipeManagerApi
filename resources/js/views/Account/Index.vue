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

    <div ref="top" class="column is-one-third">
      <h3
        @click.prevent="$router.push({ name: 'recipes.add' })"
        class="title add-cursor"
      >{{ user.admin ? $t('All recipes') : $t('Your recipes') }}</h3>
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
      <pagination
        v-if="recipes.last_page > 1"
        position="start"
        :current="recipes.current_page"
        :last="recipes.last_page"
        :route-name="this.$route.name"
        query-url="recipe-page"
        @load="loadRecipes"
      />
    </div>

    <div class="column is-one-third">
      <h3
        @click.prevent="$router.push({ name: 'cookbooks.add' })"
        class="title add-cursor"
      >{{ user.admin ? $t('All cookbooks') : $t('Your cookbooks') }}</h3>
      <ul>
        <li :key="cookbook.id" v-for="cookbook in sortedCookbooks">
          <span>
            <button
              v-if="!cookbook.deleted_at"
              @click.prevent="removeCookbook(cookbook)"
              class="button is-white is-small"
            >
              <i class="fas fa-trash"></i>
            </button>
            <button
              v-else
              @click.prevent="restoreCookbook(cookbook)"
              class="button is-white is-small"
            >
              <i class="fas fa-redo"></i>
            </button>
            <button @click.prevent="editCookbook(cookbook)" class="button is-white is-small">
              <i class="fas fa-edit"></i>
            </button>
            {{ cookbook.name }}
          </span>
        </li>
      </ul>
      <pagination
        v-if="cookbooks.last_page > 1"
        position="start"
        :current="cookbooks.current_page"
        :last="cookbooks.last_page"
        :route-name="this.$route.name"
        query-url="cookbook-page"
        @load="loadCookbooks"
      />
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import EditCookbook from "./EditCookbook";

export default {
  data() {
    return {
      showAddCookbook: false,
      currentRecipePage: 1,
      currentCookbookPage: 1
    };
  },
  computed: {
    ...mapState({
      recipes: state => state.recipes.data,
      cookbooks: state => state.cookbooks.data,
      user: state => state.user.data
    }),
    ...mapGetters({
      loggedIn: "user/loggedIn"
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
  mounted() {
    setTimeout(() => {
      if (!this.loggedIn) {
        this.$router.push({ name: "home" });
      } else if (!this.user.has_verified_email) {
        this.$router.push({ name: "verify.email" });
      }

      this.loadRecipes(1, false);
      this.$store.dispatch("cookbooks/index", { trashed: true, page: 1 });
    }, 500);
  },
  methods: {
    loadCookbooks(page = 1, scroll = true) {
      this.currentCookbookPage = page;
      this.$store.dispatch("cookbooks/index", { trashed: true, page });

      this.loadRecipes(this.currentRecipePage);

      if (scroll) {
        this.$refs.top.scrollIntoView({ behavior: "smooth" });
      }
    },
    loadRecipes(page = 1, scroll = true) {
      this.currentRecipePage = page;
      this.$store.dispatch("recipes/index", {
        trashed: true,
        only_own: !this.user.admin,
        page
      });

      if (scroll) {
        this.$refs.top.scrollIntoView({ behavior: "smooth" });
      }
    },
    async removeCookbook(cookbook) {
      await this.$store.dispatch("cookbooks/remove", { id: cookbook.id });
      await this.loadRecipes(this.currentRecipePage);
    },
    async restoreCookbook(cookbook) {
      await this.$store.dispatch("cookbooks/restore", { id: cookbook.id });
      this.loadRecipes(this.currentRecipePage);
    },
    async editCookbook(cookbook) {
      this.$buefy.modal.open({
        parent: this,
        component: EditCookbook,
        hasModalCard: true,
        trapFocus: true,
        props: { cookbook },
        events: {
          confirm: () => {
            this.$store.dispatch("cookbooks/index", {
              trashed: true,
              page: cookbooks.current_page
            });
          }
        }
      });
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

li > span {
  display: flex;
  align-items: center;
}

.button.is-small {
  padding-left: 0.5em;
  padding-right: 0.5em;
}
</style>
