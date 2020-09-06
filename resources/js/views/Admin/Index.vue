<template>
  <div class="columns">
    <div class="column">
      <h3 class="title is-4">{{ $t('Users') }}</h3>
      <ul>
        <li :key="u.id" v-for="u in users">
          <span v-if="u.name != user.name">
            <button
              v-if="!u.deleted_at"
              @click.prevent="removeUser(u.id)"
              class="button is-white is-small"
            >
              <i class="fas fa-trash"></i>
            </button>
            <button v-else @click.prevent="restoreUser(u.id)" class="button is-white is-small">
              <i class="fas fa-redo"></i>
            </button>
            {{ u.name }}
          </span>
        </li>
      </ul>
    </div>

    <div class="column">
      <h3 class="title is-4">{{ $t('Units') }}</h3>
      <ul>
        <li :key="unit.id" v-for="unit in units">
          <span>
            <button
              v-if="!unit.deleted_at"
              @click.prevent="removeUnit(unit.id)"
              class="button is-white is-small"
              :disabled="!unit.can_delete"
            >
              <i class="fas fa-trash"></i>
            </button>
            <button v-else @click.prevent="restoreUnit(unit.id)" class="button is-white is-small">
              <i class="fas fa-redo"></i>
            </button>
            {{ unit.name }}
          </span>
        </li>
      </ul>
    </div>

    <div class="column">
      <h3 class="title is-4">{{ $t('Ingredient attributes') }}</h3>
      <ul>
        <li :key="ingredientAttribute.id" v-for="ingredientAttribute in ingredientAttributes">
          <span>
            <button
              v-if="!ingredientAttribute.deleted_at"
              @click.prevent="removeIngredientAttribute(ingredientAttribute.id)"
              class="button is-white is-small"
              :disabled="!ingredientAttribute.can_delete"
            >
              <i class="fas fa-trash"></i>
            </button>
            <button
              v-else
              @click.prevent="restoreIngredientAttribute(ingredientAttribute.id)"
              class="button is-white is-small"
            >
              <i class="fas fa-redo"></i>
            </button>
            {{ ingredientAttribute.name }}
          </span>
        </li>
      </ul>
    </div>

    <div class="column">
      <h3 class="title is-4">{{ $t('Foods') }}</h3>
      <ul>
        <li :key="food.id" v-for="food in foods">
          <span>
            <button
              v-if="!food.deleted_at"
              @click.prevent="removeFood(food.id)"
              class="button is-white is-small"
              :disabled="!food.can_delete"
            >
              <i class="fas fa-trash"></i>
            </button>
            <button v-else @click.prevent="restoreFood(food.id)" class="button is-white is-small">
              <i class="fas fa-redo"></i>
            </button>
            {{ food.name }}
          </span>
        </li>
      </ul>
    </div>

    <div v-if="!$env.DISABLE_TAGS" class="column">
      <h3 class="title is-4">{{ $t('Tags') }}</h3>
      <ul>
        <li :key="tag.id" v-for="tag in tags">
          <span>
            <button
              v-if="!tag.deleted_at"
              @click.prevent="removeTag(tag.id)"
              class="button is-white is-small"
              :disabled="!tag.can_delete"
            >
              <i class="fas fa-trash"></i>
            </button>
            <button v-else @click.prevent="restoreTag(tag.id)" class="button is-white is-small">
              <i class="fas fa-redo"></i>
            </button>
            {{ tag.name }}
          </span>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";

export default {
  computed: {
    ...mapState({
      user: state => state.user.data,
      users: state => state.users.data,
      units: state => state.units.data,
      ingredientAttributes: state => state.ingredient_attributes.data,
      foods: state => state.foods.data,
      tags: state => state.tags.data
    }),
    ...mapGetters({
      loggedIn: "user/loggedIn"
    })
  },
  created() {
    setTimeout(() => {
      if (!this.loggedIn || !this.user.admin) {
        this.$router.push({ name: "home" });
      } else if (!this.user.has_verified_email) {
        this.$router.push({ name: "verify.email" });
      }

      this.load();
    }, 1000);
  },
  methods: {
    async load() {
      this.$store.dispatch("users/index", { trashed: true });
      this.$store.dispatch("units/index", { trashed: true });
      this.$store.dispatch("ingredient_attributes/index");
      this.$store.dispatch("foods/index", { trashed: true });
      if (!this.$env.DISABLE_TAGS && this.loggedIn) {
        this.$store.dispatch("tags/index", { trashed: true });
      }
    },
    removeUser(id) {
      this.$store.dispatch("users/remove", { id });
    },
    restoreUser(id) {
      this.$store.dispatch("users/restore", { id });
    },
    removeUnit(id) {
      this.$store.dispatch("units/remove", { id });
    },
    restoreUnit(id) {
      this.$store.dispatch("units/restore", { id });
    },
    removeIngredientAttribute(id) {
      this.$store.dispatch("ingredient_attributes/remove", { id });
    },
    restoreIngredientAttribute(id) {
      this.$store.dispatch("ingredient_attributes/restore", { id });
    },
    removeFood(id) {
      this.$store.dispatch("foods/remove", { id });
    },
    restoreFood(id) {
      this.$store.dispatch("foods/restore", { id });
    },
    removeTag(id) {
      this.$store.dispatch("tags/remove", { id });
    },
    restoreTag(id) {
      this.$store.dispatch("tags/restore", { id });
    }
  }
};
</script>

<style lang="scss" scoped>
li > span {
  display: flex;
  align-items: center;
}
</style>
