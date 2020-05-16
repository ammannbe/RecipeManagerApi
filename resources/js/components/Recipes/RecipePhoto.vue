<template>
  <div class="photo">
    <figure>
      <img @click="openModal()" :src="photo_urls[0]" :alt="recipe.name" />
    </figure>

    <modal
      v-if="recipe.photo_urls && show_photo !== false"
      :controls="true"
      :disable-next="!photoExists(show_photo + 1)"
      :disable-prev="show_photo <= 0"
      @close="closeModal()"
      @next="next()"
      @prev="prev()"
    >
      <template>
        <figure>
          <img :src="photo_urls[show_photo]" :alt="recipe.name" />
        </figure>
      </template>
    </modal>
  </div>
</template>

<script>
import RouteQueryHelper from "../../modules/RouteQueryHelper";

export default {
  props: ["recipe"],
  data() {
    return {
      show_photo: false,
      photo_urls: ["https://bulma.io/images/placeholders/128x128.png"]
    };
  },
  watch: {
    recipe() {
      if (this.recipe.photo_urls) {
        this.photo_urls = this.recipe.photo_urls;
      }
    }
  },
  mounted() {
    this.initModal();
  },
  methods: {
    initModal() {
      if (!this.$route.query.show_photo) {
        return;
      }

      let show_photo = parseInt(this.$route.query.show_photo);

      if (!this.photoExists(show_photo)) {
        this.closeModal();
        return;
      }

      this.openModal(show_photo);
    },
    openModal(index = 0) {
      this.show_photo = index;

      let query = RouteQueryHelper.pushOrReplace(
        this.$route.query,
        "show_photo",
        index
      );
      this.$router.push({ query });
    },
    closeModal() {
      this.show_photo = false;

      let query = RouteQueryHelper.remove(this.$route.query, "show_photo");
      this.$router.push({ query });
    },
    photoExists(index) {
      return typeof this.photo_urls[index] !== "undefined";
    },
    next() {
      if (!this.photoExists(this.show_photo + 1)) {
        return;
      }
      this.openModal(this.show_photo + 1);
    },
    prev() {
      if (!this.photoExists(this.show_photo - 1)) {
        return;
      }
      this.openModal(this.show_photo - 1);
    }
  }
};
</script>

<style lang="scss" scoped>
div.photo {
  display: flex;

  > figure {
    margin-right: 30px;

    > img {
      max-width: 100%;
      max-height: 200px;
      cursor: zoom-in;
    }
  }

  > .modal {
    cursor: zoom-out;

    figure {
      display: flex;
      justify-content: center;

      > img {
        width: auto;
        max-height: 100%;
        cursor: auto;
      }
    }
  }
}
</style>
