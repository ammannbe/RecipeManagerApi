<template>
  <div class="photo">
    <figure class="preview">
      <img
        @click="openModal(photoUrls.indexOf(mainPhotoPreviewUrl))"
        :src="mainPhotoPreviewUrl"
        :alt="recipe.name"
      />
    </figure>
    <div v-if="photoUrls.length > 1" class="small-previews">
      <figure :key="photoUrls.indexOf(photoUrl)" v-for="photoUrl in photoUrls">
        <img @click="mainPhotoPreviewUrl = photoUrl" :src="photoUrl" :alt="recipe.name" />
      </figure>
    </div>

    <modal
      v-if="recipe.photo_urls && showPhoto !== false"
      :controls="true"
      :disable-next="!photoExists(showPhoto + 1)"
      :disable-prev="showPhoto <= 0"
      @close="closeModal()"
      @next="next()"
      @prev="prev()"
    >
      <template>
        <figure>
          <img :src="photoUrls[showPhoto]" :alt="recipe.name" />
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
      showPhoto: false,
      photoUrls: ["https://bulma.io/images/placeholders/128x128.png"],
      mainPhotoPreviewUrl: "https://bulma.io/images/placeholders/128x128.png"
    };
  },
  watch: {
    recipe() {
      if (this.recipe.photo_urls) {
        this.photoUrls = this.recipe.photo_urls;
        this.mainPhotoPreviewUrl = this.photoUrls[0];
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

      let showPhoto = parseInt(this.$route.query.show_photo);

      if (!this.photoExists(showPhoto)) {
        this.closeModal();
        return;
      }

      this.openModal(showPhoto);
    },
    openModal(index = 0) {
      if (!this.recipe.photo_urls) {
        return;
      }
      this.showPhoto = index;

      let query = RouteQueryHelper.pushOrReplace(
        this.$route.query,
        "show_photo",
        index
      );
      this.$router.push({ query });
    },
    closeModal() {
      this.showPhoto = false;

      let query = RouteQueryHelper.remove(this.$route.query, "show_photo");
      this.$router.push({ query });
    },
    photoExists(index) {
      return typeof this.photoUrls[index] !== "undefined";
    },
    next() {
      if (!this.photoExists(this.showPhoto + 1)) {
        return;
      }
      this.openModal(this.showPhoto + 1);
    },
    prev() {
      if (!this.photoExists(this.showPhoto - 1)) {
        return;
      }
      this.openModal(this.showPhoto - 1);
    }
  }
};
</script>

<style lang="scss" scoped>
div.photo {
  display: flex;
  flex-direction: column;

  > .preview {
    margin-right: 30px;
    display: flex;
    align-items: center;
    justify-content: center;

    > img {
      max-width: 100%;
      max-height: 200px;
      width: 100%;
      object-fit: contain;
      cursor: zoom-in;
    }
  }

  > .small-previews {
    display: flex;
    margin-right: 30px;

    > figure {
      width: 40px;
      height: 40px;
      margin: 5px 5px 0 0;
      cursor: pointer;

      > img {
        height: 100%;
        width: 100%;
      }
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
