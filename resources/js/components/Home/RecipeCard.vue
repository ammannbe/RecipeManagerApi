<template>
  <router-link
    class="card"
    tag="a"
    :to="{ name: 'recipes', params: { id: recipe.id, slug: recipe.slug } }"
  >
    <header class="card-header-title is-centered">{{ recipe.name }}</header>

    <div class="card-content">
      <div v-if="recipe.photos" class="media is-centered">
        <figure>
          <img :src="recipe.photo_urls[0]" :alt="recipe.name" />
        </figure>
      </div>
      <div class="content" v-html="instructions"></div>
    </div>

    <footer class="card-footer">
      <div>
        <span class="time">{{ recipe.preparation_time | humanReadablePreparationTime }}</span>
      </div>
      <div>
        <span class="stars" v-for="star in recipe.stars" :key="star">*</span>
      </div>
    </footer>
  </router-link>
</template>

<script>
export default {
  props: ["recipe"],
  computed: {
    instructions() {
      return this.$markdownIt.render(this.recipe.instructions.substr(0, 100));
    }
  }
};
</script>

<style lang="scss" scoped>
.card {
  display: flex;
  flex-direction: column;
  box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);

  header {
    align-items: flex-start;
  }

  .media {
    justify-content: center;

    img {
      max-height: 170px;
    }
  }

  .content {
    font-size: 90%;
  }

  footer {
    height: 35px;
    padding: 5px;
  }
}
</style>

<style>
.content > * {
  margin-top: 0 !important;
  margin-bottom: 0.4em !important;
}
</style>
