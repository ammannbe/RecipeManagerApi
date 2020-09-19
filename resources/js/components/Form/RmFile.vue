<template>
  <b-field
    class="container"
    :label-position="labelPosition"
    :horizontal="horizontal"
    :message="message"
    :type="type"
  >
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

    <div class="tags" v-if="preview">
      <div v-for="(file, index) in model" :key="index">
        <i v-if="canCrop" class="fas fa-crop" @click="crop(file, index)"></i>
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
import RmImageCropModal from "./RmImageCropModal";

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

    "accept",
    "multiple",
    "dragDrop",
    "preview",
    "canCrop"
  ],
  computed: {
    model: {
      get() {
        return this.value;
      },
      set(value) {
        if (!Array.isArray(value)) {
          this.$emit("input", [value]);
          return;
        }

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
    },
    crop(file, index) {
      this.$buefy.modal.open({
        parent: this,
        component: RmImageCropModal,
        hasModalCard: true,
        trapFocus: true,
        props: { url: this.url(file), filename: file.name },
        events: {
          confirm: file => {
            let files = this.model;
            files[index] = file;
            this.model = files;
          }
        }
      });
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
    position: relative;

    > i {
      position: absolute;
      right: 15px;
      top: 15px;
      cursor: pointer;
    }

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

<style lang="scss">
.field.container {
  > .field-body {
    > .field.has-addons {
      flex-direction: column;
      align-items: center;
    }
  }
}
</style>
