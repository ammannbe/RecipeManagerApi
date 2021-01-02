<template>
  <rm-modal-form
    :title="$t('Add photos')"
    :confirm-text="$t('Add')"
    @close="$emit('close')"
    @confirm="submit"
  >
    <span>{{ $t('Max file size: 2MB') }}</span><br>
    <span>{{ $t('Optimal ratio: 1x1') }}</span>
    <br><br>
    <rm-file
      v-model="photos"
      :placeholder="$t('Please choose...')"
      accept="image/*"
      :preview="true"
      :can-crop="true"
      drag-drop
      multiple
      required
      autofocus
    />
  </rm-modal-form>
</template>

<script>
export default {
  props: ["id"],
  data() {
    return {
      photos: null
    };
  },
  methods: {
    async submit() {
      await this.$store.dispatch("recipe/addPhotos", {
        recipeId: this.id,
        photos: this.photos
      });

      this.$emit("confirm");
      this.$emit("close");
    }
  }
};
</script>
