<template>
  <div>
    <div v-if="hidden">
      <rm-button @click="add()" :title="$t('Add rating')">
        <i class="fas fa-plus"></i>
      </rm-button>
    </div>

    <div v-if="ratings && ratings.data && ratings.data.length">
      <a class="hide-ratings" @click="$store.dispatch('ratings/toggleHidden')">
        <span v-if="!hidden">
          <i class="fas fa-eye-slash"></i>
          {{ $t("Hide ratings") }}
        </span>
        <span v-else>
          <i class="fas fa-eye"></i>
          {{ $t("Show ratings") }}
        </span>
      </a>

      <div v-if="!hidden">
        <h2 class="title is-4">{{ $t("Ratings") }}</h2>
        <rating-card
          v-for="rating in ratings.data"
          :key="rating.id"
          :rating="rating"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import RatingCard from "./RatingCard";

export default {
  components: {
    RatingCard
  },
  computed: {
    ...mapState({
      recipe: state => state.recipe.data,
      ratings: state => state.ratings.data,
      hidden: state => state.ratings.hidden,
      editmode: state => state.recipe.editmode.data,
      form: state => state.recipe.form.data
    })
  },
  created() {
    if (!this.$env.DISABLE_RATINGS) {
      const filter = { recipe_id: this.recipe.id };
      this.$store.dispatch("ratings/index", { filter });
    }
  },
  methods: {
    add() {}
  }
};
</script>

<style lang="scss" scoped>
.hide-ratings {
  display: block;
  margin-bottom: 1.5em;
}
</style>
