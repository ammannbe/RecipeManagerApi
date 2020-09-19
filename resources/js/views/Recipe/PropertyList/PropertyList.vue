<template>
  <form @submit.prevent="$emit('update')">
    <ul>
      <property-list-item
        v-if="!$env.DISABLE_COOKBOOK && recipe.cookbook"
        :label="$t('Cookbook')"
        :value="recipe.cookbook | name | hyphenate"
      >
        <rm-select
          v-model="cookbook_id"
          size="is-small"
          :options="[{ id: null, name: 'Öffentlich' }, ...cookbooks]"
        />
      </property-list-item>

      <property-list-item
        :label="$t('Author')"
        :value="recipe.author.name"
        :disable-editing="true"
      />

      <property-list-item :label="$t('Category')" :value="recipe.category | name | hyphenate">
        <rm-select v-model="category_id" size="is-small" :options="categories" required />
      </property-list-item>

      <property-list-item :label="$t('Yield amount')">
        <rm-numberinput
          v-model="yield_amount"
          size="is-small"
          :min="0"
          :max="999"
          :step="1"
          :placeholder="$t('Enter yield amount...')"
        />
        <template v-slot:fallback>
          <rm-numberinput
            v-model="yieldAmountMultiplier"
            size="is-small"
            :min="0"
            :max="999"
            :step="1"
            :placeholder="$t('Enter yield amount...')"
          />
        </template>
      </property-list-item>

      <property-list-item :label="$t('Complexity')" :value="recipe.complexity | name | hyphenate">
        <rm-select v-model="complexity" size="is-small" :options="complexities" required />
      </property-list-item>

      <property-list-item :label="$t('Preparation time')" :value="recipe.preparation_time">
        <rm-timepicker v-model="preparation_time" size="is-small"></rm-timepicker>
        <template v-slot:fallback>
          <span
            style="margin-bottom: 0.5em"
          >{{ preparation_time | humanReadablePreparationTime | hyphenate }}</span>
        </template>
      </property-list-item>

      <property-list-item v-if="!$env.DISABLE_TAGS" :label="$t('Tags')">
        <rm-multiselect
          style="margin-bottom: 0.5em;"
          v-model="tags"
          size="is-small"
          :placeholder="$t('Choose tags...')"
          :options="tags"
        />
        <template v-if="recipe.tags && recipe.tags.length" v-slot:fallback>
          <router-link
            style="margin-bottom: 0.5em;"
            :key="tag.id"
            v-for="tag in recipe.tags"
            class="tag is-success"
            tag="a"
            :to="{ name: 'home', query: { 'search[tag]': tag.slug } }"
          >{{ tag.name }}</router-link>
        </template>
        <template v-else v-slot:fallback>
          <span style="margin-bottom: 0.5em;">-</span>
        </template>
      </property-list-item>
    </ul>

    <rm-submit-button v-if="editmode.editing">
      {{ $t('Save') }}
      <template v-slot:buttons>
        <b-button
          @click="$store.dispatch('recipe/editmode/edit', { editing: false })"
          type="is-danger"
        >{{ $t('Cancel') }}</b-button>
      </template>
    </rm-submit-button>
  </form>
</template>

<script>
import { mapState } from "vuex";
import PropertyListItem from "./PropertyListItem";
import { createHelpers } from "vuex-map-fields";

const { mapFields } = createHelpers({
  getterType: "recipe/form/getFormFields",
  mutationType: "recipe/form/updateFormFields"
});

export default {
  components: { PropertyListItem },
  data() {
    return {
      yieldAmountMultiplier: 0
    };
  },
  computed: {
    ...mapState({
      tags: state => state.tags.data,
      categories: state => state.categories.data,
      cookbooks: state => state.cookbooks.data.data,
      complexities: state => state.recipe.complexities,
      recipe: state => state.recipe.data,
      form: state => state.recipe.form.data,
      editmode: state => state.recipe.editmode.data
    }),
    ...mapFields([
      "cookbook_id",
      "category_id",
      "complexity",
      "yield_amount",
      "tags",
      "preparation_time"
    ])
  },
  watch: {
    yieldAmountMultiplier(value, oldValue) {
      if (oldValue != null) {
        if (this.recipe.yield_amount != value) {
          let yield_amount = value;
          this.$router.push({ query: { ...this.$route.query, yield_amount } });
        } else {
          let query = Object.assign({}, this.$route.query);
          delete query.yield_amount;
          this.$router.push({ query });
        }
      }

      const multiply = (1 / (this.recipe.yield_amount || 1)) * (value || 1);
      this.$emit("multiply", multiply);
    }
  },
  mounted() {
    setTimeout(() => {
      let yieldAmount = this.$route.query.yield_amount;
      if (!yieldAmount) {
        yieldAmount = this.recipe.yield_amount;
      }
      this.yieldAmountMultiplier = yieldAmount;
    }, 1000);
  }
};
</script>

<style lang="scss" scoped>
ul {
  margin-top: 12px;
  margin-bottom: 5px;
}
</style>
