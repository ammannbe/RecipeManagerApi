<template>
  <b-carousel :autoplay="false" indicator-custom :indicator-inside="false" :overlay="gallery">
    <b-carousel-item v-for="(item, i) in photoUrls.length" :key="i">
      <a @click="switchGallery(true)" class="image">
        <img :alt="alt" :src="getImgUrl(i)" />
      </a>
    </b-carousel-item>
    <span v-if="gallery" @click="switchGallery(false)" class="modal-close is-large" />
    <template slot="indicators" slot-scope="props">
      <figure class="al image" :draggable="false">
        <img :alt="alt" :draggable="false" :src="getImgUrl(props.i)" :title="alt" />
      </figure>
    </template>
  </b-carousel>
</template>

<script>
export default {
  props: ["urls", "alt"],
  data() {
    return {
      gallery: false, // TODO: check this var
      photoUrls: ["https://bulma.io/images/placeholders/128x128.png"]
    };
  },
  mounted() {
    if (this.urls) {
      this.photoUrls = this.urls;
    }
  },
  methods: {
    getImgUrl(i) {
      i += 1;
      return this.photoUrls[i - 1];
    },
    switchGallery(value) {
      this.gallery = value;
      if (value) {
        return document.documentElement.classList.add("is-clipped");
      } else {
        return document.documentElement.classList.remove("is-clipped");
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.carousel {
  margin-right: 5px;
}

.is-active .al img {
  border: 1px solid #fff;
  filter: grayscale(0%);
}

.al img {
  border: 1px solid transparent;
  filter: grayscale(100%);
}
</style>
