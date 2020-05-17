<template>
  <div class="modal is-active">
    <div @click="$emit('close')" class="modal-background"></div>
    <div class="modal-content">
      <slot></slot>
    </div>

    <div v-if="controls" class="field control">
      <button @click="$emit('prev')" class="button is-dark prev" :disabled="disablePrev">
        <i class="fas fa-angle-left"></i>
      </button>
      <button @click="$emit('next')" class="button is-dark next" :disabled="disableNext">
        <i class="fas fa-angle-right"></i>
      </button>
    </div>
    <button @click="$emit('close')" class="modal-close is-large" aria-label="close"></button>
  </div>
</template>

<script>
export default {
  props: ["controls", "disablePrev", "disableNext"],
  beforeDestroy() {
    window.removeEventListener("keyup", this.onEscapeKeyUp);

    $("html").css("overflow-y", "");
  },
  beforeCreate() {
    window.addEventListener("keyup", this.onEscapeKeyUp);

    $("html").css("overflow-y", "hidden");
  },
  methods: {
    onEscapeKeyUp(event) {
      event.which === 27 && this.$emit("close");
    }
  }
};
</script>

<style lang="scss" scoped>
.modal-content {
  max-height: calc(100vh - 30px);
}

.control {
  display: flex;
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 60px;
  margin: 0;

  > .button {
    font-size: 50px;
    width: 100%;
    height: 100%;
    border-radius: unset;
  }
}
</style>
