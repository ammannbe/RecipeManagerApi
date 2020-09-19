<template>
  <div>
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
      <template slot="no-more">{{ $t('No more data :)') }}</template>
    </infinite-loading>
  </div>
</template>

<script>
import { mapState } from "vuex";
import InfiniteLoading from "vue-infinite-loading";
import RecipeCard from "./RecipeCard";

export default {
  components: { RecipeCard, InfiniteLoading },
  props: ["filterByName"],
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
    filter() {
      if (this.filterByName) {
        return { "filter[name]": this.filterByName };
      }
      return null;
    }
  },
  created() {
    if (this.$env.PREFER_PAGINATION) {
      this.$store.dispatch("recipes/index", {
        filter: this.filter,
        limit: this.limit
      });
    }
  },
  methods: {
    load($state) {
      if (this.page >= this.recipes.last_page) {
        $state.complete();
      }
      this.$store
        .dispatch("recipes/index", {
          page: this.page,
          filter: this.filter,
          limit: this.limit,
          push: this.page !== 1
        })
        .then(() => {
          $state.loaded();
          this.page++;
        });
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
