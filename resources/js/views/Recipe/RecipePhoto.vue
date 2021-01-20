<template>
  <div>
    <div v-if="recipe.photos && recipe.photos.length">
      <b-carousel
        @click="switchGallery(true)"
        v-model="active"
        :indicator="recipe.photos.length > 1"
        :indicator-background="false"
        :indicator-inside="true"
        indicator-mode="click"
        indicator-position="is-bottom"
        indicator-style="is-boxes"
        :overlay="gallery"
        :pause-hover="!gallery && recipe.photos.length > 1"
        :arrow="recipe.photos.length > 1"
      >
        <b-carousel-item v-for="photos in recipe.photos" :key="photos.id">
          <span class="image">
            <b-image
              :src="gallery !== true ? photos.url + '?thumbnail' : photos.url"
              :src-fallback="$env.NOT_FOUND_IMAGE"
            />
          </span>
        </b-carousel-item>

        <span
          v-if="gallery"
          @click="switchGallery(false)"
          class="modal-close is-large"
        />
      </b-carousel>
    </div>

    <div v-else-if="placeholder">
      <b-carousel :indicator="false" :arrow="false" :pause-hover="false">
        <b-carousel-item id="carousel" class="placeholder">
          <span class="image">
            <b-image :src="placeholder" :placeholder="placeholder" />
          </span>
        </b-carousel-item>
      </b-carousel>
    </div>

    <div v-if="editmode.editing" class="edit-buttons">
      <rm-button @click="add()" :title="$t('Add photos')">
        <i class="fas fa-plus"></i>
      </rm-button>
      <rm-button
        :is-danger="true"
        v-if="recipe.photos && recipe.photos.length"
        @click="remove(active)"
        :title="$t('Delete the current photo')"
      >
        <i class="fas fa-trash"></i>
      </rm-button>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import AddRecipePhoto from "./AddRecipePhoto";

export default {
  data() {
    return {
      active: 0,
      gallery: false
    };
  },
  computed: {
    ...mapState({
      recipe: state => state.recipe.data,
      editmode: state => state.recipe.editmode.data
    }),
    indicator() {
      return !this.gallery;
    },
    placeholder() {
      return this.$env.PLACEHOLDER_IMAGE;
    }
  },
  methods: {
    add() {
      this.modalOpen = true;
      this.$buefy.modal.open({
        parent: this,
        component: AddRecipePhoto,
        hasModalCard: true,
        trapFocus: true,
        props: { id: this.recipe.id }
      });
    },
    remove(index) {
      const photo = this.recipe.photos[index];
      const recipeId = this.recipe.id;

      this.$buefy.dialog.confirm({
        title: this.$t("Delete this photo?"),
        message: `<img src="/images/recipes/${photo.id}/${photo.name}">`,
        cancelText: this.$t("Cancel"),

        onConfirm: () => {
          this.$store.dispatch("recipe/removePhoto", {
            recipeId,
            id: photo.id
          });
        }
      });
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
  padding: initial;
  margin: 0.75em;

  &:not(.is-overlay) {
    cursor: pointer;
  }

  &.is-overlay {
    z-index: 999999;
    margin: 0;
  }
}

.is-active .al img {
  filter: grayscale(0%);
}

.al img {
  filter: grayscale(100%);
}

.edit-buttons {
  display: flex;
  justify-content: center;

  > div {
    display: inline-flex;
    margin: 5px 10px;
  }
}
</style>

<style lang="scss">
.carousel {
  &.is-overlay {
    > .carousel-items {
      height: 80%;

      > .carousel-item {
        height: 100%;
      }
    }
  }

  > .carousel-items {
    > .carousel-item {
      height: 250px;

      @media screen and (max-width: 768px) {
        height: 312px;
      }

      &.placeholder {
        cursor: initial;
      }

      > span.image {
        height: 100%;

        > figure.image {
          height: 100%;

          > img {
            height: 100%;
            object-fit: contain;
          }
        }
      }
    }
  }
}
</style>
