<template>
  <b-carousel :indicator-inside="false">
    <b-carousel-item v-for="(url, i) in photoUrls" :key="i">
      <span class="image">
        <img :src="url" />
      </span>
    </b-carousel-item>
  </b-carousel>
</template>

<script>
export default {
  props: ["urls", "alt"],
  data() {
    return {
      gallery: false,
      photoUrls: ["https://bulma.io/images/placeholders/128x128.png"]
    };
  },
  mounted() {
    if (this.urls) {
      this.photoUrls = this.urls;
    }
  }
};
</script>

<style lang="scss" scoped>
.carousel {
  margin-right: 5px;
}

.is-active .al img {
  filter: grayscale(0%);
}

.al img {
  filter: grayscale(100%);
}
</style>
