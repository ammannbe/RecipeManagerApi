<template>
  <b-steps v-model="step" :has-navigation="false">
    <b-step-item :step="0" :label="$t('Infos')" :type="{'is-success': success.informations}">
      <infos @input="recipe = $event" @next="step++" />
    </b-step-item>

    <b-step-item :step="1" :label="$t('Ingredients')" :type="{'is-success': success.ingredients}">
      <ingredients @input="ingredients = $event" @next="step++" @back="step--" />
    </b-step-item>

    <b-step-item :step="2" :label="$t('Instructions')" :type="{'is-success': success.instructions}">
      <instructions @input="instructions = $event" @next="step++" @back="step--" />
    </b-step-item>

    <b-step-item :step="3" :label="$t('Photos')" :type="{'is-success': success.photos}">
      <photos @input="photos = $event" @next="submit" @back="step--" />
    </b-step-item>
  </b-steps>
</template>

<script>
import { mapState, mapGetters } from "vuex";
import Infos from "./Infos";
import Ingredients from "./Ingredients";
import Instructions from "./Instructions";
import Photos from "./Photos";

export default {
  components: { Infos, Ingredients, Instructions, Photos },
  computed: {
    ...mapState({
      user: state => state.user.data
    }),
    ...mapGetters({
      loggedIn: "user/loggedIn"
    })
  },
  data() {
    return {
      step: 0,
      success: {
        informations: false,
        ingredients: false,
        instructions: false,
        photos: false
      },
      recipe: {},
      ingredients: [],
      instructions: null,
      photos: []
    };
  },
  mounted() {
    setTimeout(() => {
      if (!this.loggedIn) {
        this.$router.push({ name: "home" });
      } else if (!this.user.has_verified_email) {
        this.$router.push({ name: "verify.email" });
      }
    }, 1000);

    this.$store.dispatch("categories/index", {});
    this.$store.dispatch("units/index", {});
    this.$store.dispatch("foods/index", {});
    this.$store.dispatch("ingredient_attributes/index", {});

    if (!this.$env.DISABLE_COOKBOOKS) {
      this.$store.dispatch("cookbooks/index", { limit: 1000 });
    }

    if (!this.$env.DISABLE_TAGS) {
      this.$store.dispatch("tags/index", {});
    }
  },
  methods: {
    async submit() {
      const data = { ...this.recipe, ...this.instructions, ...this.photos };
      const recipe = await this.$store.dispatch("recipe/store", { data });

      this.ingredients.forEach(ingredient => {
        this.$store.dispatch("ingredients/store", {
          recipeId: recipe.id,
          data: ingredient
        });
      });

      this.$router.push({
        name: "recipes",
        params: { id: recipe.id, slug: recipe.slug }
      });
    }
  }
};
</script>
