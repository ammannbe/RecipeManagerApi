<template>
  <div class="social-sharing" :class="{'hidden': !enabled}">
    <!-- Telegram -->
    <a :href="telegram" target="_blank" :title="$t('Share via Telegram')">
      <i class="fab fa-telegram"></i>
    </a>

    <!-- Email -->
    <a :href="email" :title="$t('Share via email')">
      <i class="fas fa-envelope"></i>
    </a>

    <!-- PDF Download -->
    <a @click="downloadPdf()" :title="$t('Download as PDF')">
      <i class="fas fa-print"></i>
    </a>

    <a class="delete" @click="$store.dispatch('socialsharing/hide')"></a>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: ["url", "name", "author", "category"],
  computed: {
    ...mapState({
      enabled: state => state.socialsharing.enabled,
      recipe: state => state.recipe.data
    }),
    telegram() {
      return `//telegram.me/share/url?url=${this.url}&text=${this.name}`;
    },
    email() {
      return (
        `mailto:?Subject=${this.name}&amp;Body=` +
        `${this.name}%0D%0A${this.author}%0D%0A${this.category}%0D%0A${this.url}`
      );
    }
  },
  methods: {
    downloadPdf() {
      this.$store.dispatch("recipe/pdf").then(pdf => {
        const link = document.createElement("a");
        link.href = pdf;
        link.setAttribute("download", `${this.recipe.name}.pdf`);
        document.body.appendChild(link);
        link.click();
      });
    }
  }
};
</script>

<style lang="scss" scoped>
div.hidden {
  visibility: hidden;
}

div.social-sharing {
  position: relative;

  > a > i {
    font-size: 2.5rem;
    margin-right: 10px;

    &.fa-telegram {
      color: #2da5e1;
    }

    &.fa-envelope {
      color: #769e5d;
    }

    &.fa-print {
      color: #4d4d4d;
    }
  }
}
</style>
