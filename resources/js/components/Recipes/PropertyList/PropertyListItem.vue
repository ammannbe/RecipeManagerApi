<template>
  <li>
    <span
      :title="title"
      :class="{'can-edit': editmode.enabled && !disableEditing}"
      @click="editing = !editing"
    >{{ label }}:&nbsp;</span>
    <slot v-if="editing"></slot>
    <slot
      v-else
      name="fallback"
      :class="{'can-edit': editmode.enabled && !disableEditing}"
      @click="editing = !editing"
    >
      <span>{{ value }}</span>
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
        return "Klicken zum Bearbeiten";
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

        this.$store.commit("recipe/editmode/edit", { editing });
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.can-edit {
  cursor: pointer;
}
</style>
