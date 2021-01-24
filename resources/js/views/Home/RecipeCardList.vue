<template>
  <div>
    <div v-if="!loaded" ref="top" class="columns is-centered">
      <recipe-card-skeleton
        v-for="i in limit"
        :key="i"
        class="column is-5-tablet is-one-fifth-fullhd"
      />
    </div>

    <div ref="top" class="columns is-centered">
      <recipe-card
        v-for="recipe in recipes.data"
        :key="recipe.id"
        :recipe="recipe"
        class="column is-5-tablet is-one-fifth-fullhd"
      ></recipe-card>
    </div>

    <pagination
      v-if="$env.PREFER_PAGINATION"
      :current="recipes.current_page"
      :last="recipes.last_page"
      :route-name="this.$route.name"
      query-url="recipe-page"
      @load="loadPagination"
    ></pagination>
    <infinite-loading v-else @infinite="load">
      <template slot="no-more">&nbsp;</template>
    </infinite-loading>
  </div>
</template>

<script>
import { mapState } from "vuex";
import InfiniteLoading from "vue-infinite-loading";
import RecipeCard from "./RecipeCard";
import RecipeCardSkeleton from "./RecipeCardSkeleton";

export default {
  components: { RecipeCard, RecipeCardSkeleton, InfiniteLoading },
  props: ["search"],
  data() {
    return {
      limit: 16,
      page: 1
    };
  },
  computed: {
    ...mapState({
      recipes: state => state.recipes.data
    }),
    loaded() {
      return !!this.recipes.data;
    }
  },
  created() {
    if (this.search) {
      this.$store.dispatch("recipes/search", {
        limit: this.limit,
        search: this.search
      });
    } else {
      this.$store.dispatch("recipes/index", { limit: this.limit });
    }
  },
  methods: {
    load($state) {
      if (this.page >= this.recipes.last_page) {
        $state.complete();
      }
      if (this.search) {
        this.$store
          .dispatch("recipes/search", {
            page: this.page,
            search: this.search,
            limit: this.limit,
            push: this.page !== 1
          })
          .then(() => {
            $state.loaded();
            this.page++;
          });
      } else {
        this.$store
          .dispatch("recipes/index", {
            page: this.page,
            limit: this.limit,
            push: this.page !== 1
          })
          .then(() => {
            $state.loaded();
            this.page++;
          });
      }
    },
    loadPagination(page) {
      this.$store.dispatch("recipes/index", {
        page,
        filter: this.filter,
        limit: this.limit
      });
      document.getElementById("app").scrollIntoView({ behavior: "smooth" });
    }
  }
};
</script>

<style lang="scss" scoped>
div.columns {
  flex-wrap: wrap;

  > .column {
    margin: 10px;
  }
}
</style>

<style lang="scss">
.infinite-status-prompt {
  display: none;
}
</style>
