<template>
  <div>
    <rm-switch v-if="show" :value="value" @input="$emit('input', $event)">
      <i class="fas fa-edit"></i>
    </rm-switch>
  </div>
</template>

<script>
export default {
  props: ["value", "condition"],
  computed: {
    show() {
      return this.$Laravel.isLoggedIn && this.condition;
    }
  }
};
</script>
