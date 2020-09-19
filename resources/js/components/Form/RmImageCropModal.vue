<template>
  <rm-modal-form
    :title="$t('Crop photo')"
    :confirm-text="$t('Crop')"
    @close="$emit('close')"
    @confirm="crop"
  >
    <clipper-basic :ratio="1" class="clipper" ref="clipper" :src="url">
      <div class="placeholder" slot="placeholder">{{ $t('No photo') }}</div>
    </clipper-basic>
  </rm-modal-form>
</template>

<script>
export default {
  props: ["url", "filename"],
  methods: {
    crop() {
      const canvas = this.$refs.clipper.clip(); // call component's clip method
      const dataUrl = canvas.toDataURL("image/png", 1);

      const urlArray = dataUrl.split(",");
      const mime = urlArray[0].match(/:(.*?);/)[1];

      const bstr = atob(urlArray[1]);
      let n = bstr.length;
      let u8arr = new Uint8Array(n);
      while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
      }

      const file = new File([u8arr], this.filename, { type: mime });

      this.$emit("confirm", file);
      this.$emit("close");
    }
  }
};
</script>

<style lang="scss" scoped>
.clipper {
  width: 100%;
  max-width: 700px;
}

.placeholder {
  text-align: center;
  padding: 20px;
  background-color: lightgray;
}
</style>
