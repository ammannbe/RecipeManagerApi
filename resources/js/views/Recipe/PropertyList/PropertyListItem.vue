<template>
  <li>
    <span
      :title="title"
      class="label"
      :class="{'can-edit': editmode.enabled && !disableEditing}"
      @click="editing = !editing"
    >{{ label }}:&nbsp;</span>
    <slot v-if="editing"></slot>
    <slot
      v-else
      name="fallback"
      class="value"
      :class="{'can-edit': editmode.enabled && !disableEditing}"
      @click="editing = !editing"
    >
      <span class="value">{{ value }}</span>
    </slot>
  </li>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: ["value", "label", "disableEditing"],
  computed: {
    ...mapState({
      editmode: state => state.recipe.editmode.data
    }),
    title() {
      if (this.editmode.enabled) {
        return this.$t("Click to edit");
      }
      return "";
    },
    editing: {
      get() {
        return this.editmode.editing && !this.disableEditing;
      },
      set(editing) {
        if (this.disableEditing) {
          return;
        }

        this.$store.dispatch("recipe/editmode/edit", { editing });
      }
    }
  }
};
</script>

<style lang="scss" scoped>
li {
  display: flex;
  align-items: center;
  min-height: 30px;

  > div {
    margin: 1px;
  }

  > a {
    margin-right: 3px;
  }
}

.can-edit {
  cursor: pointer;
  margin-bottom: 8px;
}

.value {
  margin-bottom: 8px;
}
</style>
