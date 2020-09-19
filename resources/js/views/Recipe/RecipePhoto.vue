<template>
  <div>
    <div v-if="recipe.photo_urls && recipe.photo_urls.length">
      <b-carousel
        v-model="active"
        :indicator="true"
        :indicator-background="true"
        :indicator-inside="true"
        indicator-mode="click"
        indicator-position="is-top"
        indicator-style="is-lines"
      >
        <b-carousel-item id="carousel" v-for="(url, i) in recipe.photo_urls" :key="i">
          <span class="image">
            <b-image :src="url" :placeholder="placeholder" />
          </span>
        </b-carousel-item>
      </b-carousel>
    </div>

    <div v-else>
      <b-carousel
        :indicator="true"
        :indicator-background="true"
        :indicator-inside="true"
        indicator-mode="click"
        indicator-position="is-top"
        indicator-style="is-lines"
      >
        <b-carousel-item id="carousel" v-for="(url, i) in [placeholder]" :key="i">
          <span class="image">
            <b-image :src="url" :placeholder="placeholder" />
          </span>
        </b-carousel-item>
      </b-carousel>
    </div>

    <div v-if="editmode.editing" class="edit-buttons">
      <rm-button @click="add()">
        <i class="fas fa-plus"></i>
      </rm-button>
      <rm-button
        :is-danger="true"
        v-if="recipe.photo_urls && recipe.photo_urls.length"
        @click="remove(active)"
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
      placeholder: "https://bulma.io/images/placeholders/480x480.png",
      active: 0
    };
  },
  computed: {
    ...mapState({
      recipe: state => state.recipe.data,
      editmode: state => state.recipe.editmode.data
    })
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
      const id = this.recipe.id;
      const photo = Object.values(this.recipe.photos)[index];

      this.$buefy.dialog.confirm({
        title: this.$t("Delete this photo?"),
        message: `<img src="/images/recipes/${id}/${photo}">`,
        cancelText: this.$t("Cancel"),

        onConfirm: () => {
          this.$store.dispatch("recipe/removePhoto", { id, photo });
        }
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.carousel {
  padding: initial;
  margin: 0.75em;
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
#carousel {
  height: 250px;

  @media screen and (max-width: 768px) {
    height: 400px;
  }

  @media screen and (max-width: 360px) {
    height: 350px;
  }
}
</style>
