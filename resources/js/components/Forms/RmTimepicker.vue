<template>
  <b-field :label="label" :horizontal="horizontal" :message="message">
    <b-timepicker
      v-model="model"
      :size="size"
      :placeholder="placeholder"
      :open-on-focus="true"
      style="max-width: 300px"
    />
  </b-field>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: ["value", "label", "horizontal", "message", "size", "placeholder"],
  computed: {
    model: {
      get() {
        if (this.value === null) {
          return;
        }

        const [hours, minutes] = this.value.split(":");
        const date = new Date();
        date.setHours(hours);
        date.setMinutes(minutes);

        return date;
      },
      set(value) {
        const pad = function(n) {
          return n < 10 ? "0" + n : n;
        };
        let hours = pad(value.getHours());
        let minutes = pad(value.getMinutes());

        this.$emit("input", `${hours}:${minutes}`);
      }
    }
  }
};
</script>
