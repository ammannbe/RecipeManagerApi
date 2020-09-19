<template>
  <div class="columns">
    <div class="column">
      <h3 class="title is-4 creating" @click="addOrEditUser()">{{ $t('Users') }}</h3>
      <ul>
        <li :key="u.id" v-for="u in users">
          <span v-if="u.name != user.name">
            <button
              v-if="!u.deleted_at"
              @click.prevent="removeUser({ id: u.id })"
              class="button is-white is-small"
            >
              <i class="fas fa-trash"></i>
            </button>
            <button
              v-else
              @click.prevent="restoreUser({ id: u.id })"
              class="button is-white is-small"
            >
              <i class="fas fa-redo"></i>
            </button>
            <button
              :disabled="u.deleted_at"
              @click.prevent="addOrEditUser(u)"
              class="button is-white is-small"
            >
              <i class="fas fa-edit"></i>
            </button>
            {{ u.name }}
          </span>
        </li>
      </ul>
    </div>

    <div class="column">
      <h3 class="title is-4 creating" @click="addOrEditUnit()">{{ $t('Units') }}</h3>
      <ul>
        <li :key="unit.id" v-for="unit in units">
          <span>
            <button
              v-if="!unit.deleted_at"
              @click.prevent="removeUnit({ id: unit.id })"
              class="button is-white is-small"
              :disabled="!unit.can_delete"
            >
              <i class="fas fa-trash"></i>
            </button>
            <button
              v-else
              @click.prevent="restoreUnit({ id: unit.id })"
              class="button is-white is-small"
            >
              <i class="fas fa-redo"></i>
            </button>
            <button
              :disabled="unit.deleted_at"
              @click.prevent="addOrEditUnit(unit)"
              class="button is-white is-small"
            >
              <i class="fas fa-edit"></i>
            </button>
            {{ unit.name }}
          </span>
        </li>
      </ul>
    </div>

    <div class="column">
      <h3
        class="title is-4 creating"
        @click="addOrEditIngredientAttribute()"
      >{{ $t('Ingredient attributes') }}</h3>
      <ul>
        <li :key="ingredientAttribute.id" v-for="ingredientAttribute in ingredientAttributes">
          <span>
            <button
              v-if="!ingredientAttribute.deleted_at"
              @click.prevent="removeIngredientAttribute({ id: ingredientAttribute.id })"
              class="button is-white is-small"
              :disabled="!ingredientAttribute.can_delete"
            >
              <i class="fas fa-trash"></i>
            </button>
            <button
              v-else
              @click.prevent="restoreIngredientAttribute({ id: ingredientAttribute.id })"
              class="button is-white is-small"
            >
              <i class="fas fa-redo"></i>
            </button>
            <button
              :disabled="ingredientAttribute.deleted_at"
              @click.prevent="addOrEditIngredientAttribute(ingredientAttribute)"
              class="button is-white is-small"
            >
              <i class="fas fa-edit"></i>
            </button>
            {{ ingredientAttribute.name }}
          </span>
        </li>
      </ul>
    </div>

    <div class="column">
      <h3 class="title is-4 creating" @click="addOrEditFood()">{{ $t('Foods') }}</h3>
      <ul>
        <li :key="food.id" v-for="food in foods">
          <span>
            <button
              v-if="!food.deleted_at"
              @click.prevent="removeFood({ id: food.id })"
              class="button is-white is-small"
              :disabled="!food.can_delete"
            >
              <i class="fas fa-trash"></i>
            </button>
            <button
              v-else
              @click.prevent="restoreFood({ id: food.id })"
              class="button is-white is-small"
            >
              <i class="fas fa-redo"></i>
            </button>
            <button
              :disabled="food.deleted_at"
              @click.prevent="addOrEditFood(food)"
              class="button is-white is-small"
            >
              <i class="fas fa-edit"></i>
            </button>
            {{ food.name }}
          </span>
        </li>
      </ul>
    </div>

    <div v-if="!$env.DISABLE_TAGS" class="column">
      <h3 class="title is-4 creating" @click="addOrEditTag()">{{ $t('Tags') }}</h3>
      <ul>
        <li :key="tag.id" v-for="tag in tags">
          <span>
            <button
              v-if="!tag.deleted_at"
              @click.prevent="removeTag({ id: tag.id })"
              class="button is-white is-small"
              :disabled="!tag.can_delete"
            >
              <i class="fas fa-trash"></i>
            </button>
            <button
              v-else
              @click.prevent="restoreTag({ id: tag.id })"
              class="button is-white is-small"
            >
              <i class="fas fa-redo"></i>
            </button>
            <button
              :disabled="tag.deleted_at"
              @click.prevent="addOrEditTag(tag)"
              class="button is-white is-small"
            >
              <i class="fas fa-edit"></i>
            </button>
            {{ tag.name }}
          </span>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from "vuex";
import User from "./User";
import Unit from "./Unit";
import IngredientAttribute from "./IngredientAttribute";
import Food from "./Food";
import Tag from "./Tag";

export default {
  data() {
    return {
      modalOptions: {
        parent: this,
        hasModalCard: true,
        trapFocus: true
      }
    };
  },
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
  mounted() {
    setTimeout(() => {
      if (!this.loggedIn || !this.user.admin) {
        this.$router.push({ name: "home" });
      } else if (!this.user.has_verified_email) {
        this.$router.push({ name: "verify.email" });
      }

      this.load();
    }, 500);
  },
  methods: {
    async load(type = null) {
      if (type) {
        this.$store.dispatch(`${type}/index`, { trashed: true });
        return;
      }

      this.$store.dispatch("users/index", { trashed: true });
      this.$store.dispatch("units/index", { trashed: true });
      this.$store.dispatch("ingredient_attributes/index", { trashed: true });
      this.$store.dispatch("foods/index", { trashed: true });
      if (!this.$env.DISABLE_TAGS && this.loggedIn) {
        this.$store.dispatch("tags/index", { trashed: true });
      }
    },
    ...mapActions({
      removeUser: "users/remove",
      restoreUser: "users/restore",
      removeUnit: "units/remove",
      restoreUnit: "units/restore",
      removeIngredientAttribute: "ingredient_attributes/remove",
      restoreIngredientAttribute: "ingredient_attributes/restore",
      removeFood: "foods/remove",
      restoreFood: "foods/restore",
      removeTag: "tags/remove",
      restoreTag: "tags/restore"
    }),
    addOrEditUser(data) {
      this.$buefy.modal.open({
        ...this.modalOptions,
        component: User,
        props: { params: data },
        events: { confirm: () => this.load("users") }
      });
    },
    addOrEditUnit(data) {
      this.$buefy.modal.open({
        ...this.modalOptions,
        component: Unit,
        props: { params: data },
        events: { confirm: () => this.load("units") }
      });
    },
    addOrEditIngredientAttribute(data) {
      this.$buefy.modal.open({
        ...this.modalOptions,
        component: IngredientAttribute,
        props: { params: data },
        events: { confirm: () => this.load("ingredient_attributes") }
      });
    },

    addOrEditFood(data) {
      this.$buefy.modal.open({
        ...this.modalOptions,
        component: Food,
        props: { params: data },
        events: { confirm: () => this.load("foods") }
      });
    },
    addOrEditTag(data) {
      this.$buefy.modal.open({
        ...this.modalOptions,
        component: Tag,
        props: { params: data },
        events: { confirm: () => this.load("tags") }
      });
    }
  }
};
</script>

<style lang="scss" scoped>
li > span {
  display: flex;
  align-items: center;
}

.creating {
  cursor: copy;
}

.button.is-small {
  padding-left: 0.5em;
  padding-right: 0.5em;
}
</style>
