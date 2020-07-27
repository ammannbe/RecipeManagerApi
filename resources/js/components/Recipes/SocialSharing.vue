<template>
  <div class="social-sharing" :class="{'hidden': !enabled}">
    <!-- Telegram -->
    <a
      :href="'//telegram.me/share/url?url=' + url + '&text=' + name"
      target="_blank"
      :title="$t('Share via Telegram')"
    >
      <i class="fab fa-telegram"></i>
    </a>
    <!-- E-Mail -->
    <a :href="'mailto:?Subject=' + name + '&amp;Body=' + body" :title="$t('Share via email')">
      <i class="fas fa-envelope"></i>
    </a>
    <!-- Print -->
    <a @click="print()" :title="$t('Print recipe')">
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
      enabled: state => state.socialsharing.enabled
    }),
    body() {
      return `${this.name}%0D%0A${this.author}%0D%0A${this.category}%0D%0A${this.url}`;
    }
  },
  methods: {
    print() {
      window.print();
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
