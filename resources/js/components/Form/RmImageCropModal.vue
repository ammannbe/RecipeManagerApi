<template>
  <rm-modal-form
    :title="$t('Crop photo')"
    :confirm-text="$t('Crop')"
    @close="$emit('close')"
    @confirm="crop"
    class="rm-image-crop-modal"
  >
    <div class="controls">
      <rm-switch :label="$t('Fix aspect ratio')" v-model="ratioEnabled" />
      <rm-numberinput
        :label="$t('Width') + ':'"
        v-model="ratioWidth"
        :min="1"
        :controls="false"
        size="is-small"
        horizontal
      />
      <rm-numberinput
        :label="$t('Heigth') + ':'"
        v-model="ratioHeight"
        :min="1"
        :controls="false"
        size="is-small"
        horizontal
      />

      <div>{{ $t("Optimal ratio: 1x1") }}</div>
    </div>

    <clipper-basic
      :ratio="ratioEnabled ? ratio : null"
      :wrap-ratio="ratio"
      class="clipper"
      ref="clipper"
      :src="url"
    >
      <div class="placeholder" slot="placeholder">{{ $t("No photo") }}</div>
    </clipper-basic>
  </rm-modal-form>
</template>

<script>
export default {
  props: ["url", "filename"],
  data() {
    return {
      ratioEnabled: true,
      ratioWidth: 1,
      ratioHeight: 1
    };
  },
  computed: {
    ratio() {
      return this.ratioWidth / this.ratioHeight;
    }
  },
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

div.controls {
  display: flex;
  flex-wrap: wrap;
  margin-bottom: 15px;
  max-width: 400px;

  > div:nth-child(1) {
    display: flex;
    width: 100%;
    flex-direction: row-reverse;
    align-items: flex-start;
    justify-content: flex-end;

    > label:nth-child(2) {
      margin-right: 0;
    }
  }

  > div:nth-child(2) {
    margin-right: 10px;
  }
}
</style>

<style lang="scss">
.rm-image-crop-modal {
  .modal-card-body {
    display: flex;
    flex-wrap: wrap;
    flex-direction: column;

    > div:nth-child(2) {
      max-width: 50vw;
      margin: 0 auto;

      @media screen and (max-width: 430px) {
        max-width: 80vw;
      }
    }
  }

  .js-clipper-basic,
  .vuejs-clipper-basic__padding {
    max-height: 100% !important;
  }
}
</style>
