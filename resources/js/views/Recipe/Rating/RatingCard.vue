<template>
  <div>
    <div class="card">
      <div class="card-content">
        <div class="media">
          <div class="media-left">
            <span v-for="star in rating.stars" :key="star">
              <i class="fas fa-star"></i>
            </span>
            <span
              v-for="remaining in $env.MAX_RATING_STARS - rating.stars"
              :key="rating.stars + remaining"
            >
              <i class="far fa-star"></i>
            </span>
          </div>
          <div class="media-content">
            <p class="title is-4">{{ rating.rating_criterion.name }}</p>
            <p v-if="rating.author" class="subtitle is-6">
              @{{ rating.author.name }}
            </p>
          </div>
        </div>
        <div class="content">
          <p v-html="$remarkable.render(rating.comment)"></p>
        </div>
      </div>
    </div>

    <br />
  </div>
</template>

<script>
export default {
  props: ["rating"]
};
</script>

<style lang="scss" scoped>
.fa.fa-star {
  color: gold;
}

.title {
  overflow: hidden;
}
</style>
