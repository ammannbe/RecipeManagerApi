<template>
  <b-field :message="this.message">
    <b-timepicker v-model="model" :size="size"></b-timepicker>
  </b-field>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: ["value", "message", "size"],
  computed: {
    model: {
      get() {
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
