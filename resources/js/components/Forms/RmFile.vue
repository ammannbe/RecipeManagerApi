<template>
  <b-field class="container" :label-position="labelPosition" :horizontal="horizontal" :message="message" :type="type">
    <template v-if="label" slot="label">
      {{ label }}
      <span v-if="required !== undefined" class="required">*</span>
      <b-tooltip v-if="labelTooltip" type="is-dark" :label="labelTooltip">
        <b-icon size="is-small" icon="question-circle" />
      </b-tooltip>
    </template>
    <b-upload v-model="model" :accept="accept" :multiple="multiple" :drag-drop="dragDrop">
      <section class="section">
        <div class="content has-text-centered">
          <p>
            <b-icon icon="upload" size="is-large"></b-icon>
          </p>
          <p>{{ $t('Drop your files here or click to upload') }}</p>
        </div>
      </section>
    </b-upload>

    <div class="tags" v-if="preview !== undefined">
      <div v-for="(file, index) in model" :key="index">
        <img :src="url(file)" />
        <span class="tag is-primary">
          {{ file.name }}
          <button class="delete is-small" type="button" @click="deleteFile(index)"></button>
        </span>
      </div>
    </div>
  </b-field>
</template>

<script>
export default {
  props: [
    "value",
    "name",
    "label",
    "labelTooltip",
    "labelPosition",
    "horizontal",
    "message",
    "messageType",
    "placeholder",
    "disabled",
    "autofocus",
    "required",

    "maxlength",
    "accept",
    "multiple",
    "dragDrop",
    "preview"
  ],
  computed: {
    model: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit("input", value);
      }
    },
    type() {
      if (!this.message) {
        return;
      }

      if (this.messageType) {
        return this.messageType;
      }

      return "is-danger";
    }
  },
  methods: {
    deleteFile(index) {
      this.model.splice(index, 1);
    },
    url(file) {
      return URL.createObjectURL(file);
    }
  }
};
</script>

<style lang="scss" scoped>
.container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.tags {
  align-items: flex-end;

  > div {
    display: flex;
    flex-direction: column;
    align-items: center;
    border: 1px solid gray;
    border-radius: 4px;
    margin: 10px;
    padding: 0 10px;

    > img {
      max-width: 80%;
      width: 200px;
      padding: 5px;
    }
  }
}

.required {
  color: red;
}
</style>
