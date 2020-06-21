<template>
  <div class="edit-mode-switch">
    <label v-if="$Laravel.isLoggedIn && condition" for="edit-mode">
      <i class="fas fa-edit"></i>
      <input
        @click="$store.dispatch('editmode/toggle')"
        :checked="enabled"
        name="edit-mode"
        id="edit-mode"
        type="checkbox"
      />
      <span class="switch round"></span>
    </label>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: ["condition"],
  computed: {
    ...mapState({
      enabled: state => state.editmode.enabled
    })
  },
  watch: {
    enabled() {
      this.$emit("toggle", this.enabled);
    }
  }
};
</script>

<style lang="scss" scoped>
.edit-mode-switch {
  margin-right: 40px;

  > label {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;

    > i {
      display: flex;
      align-items: center;
      margin-left: 70px;
      height: 34px;
      width: 145px;
      cursor: pointer;
    }

    > input {
      opacity: 0;
      width: 0;
      height: 0;

      &:checked + span {
        background-color: #2196f3;
      }

      &:focus + span {
        box-shadow: 0 0 1px #2196f3;
      }

      &:checked + span:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
      }
    }

    > span {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: 0.4s;
      transition: 0.4s;

      &:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: 0.4s;
        transition: 0.4s;
      }

      &.round {
        border-radius: 34px;

        &:before {
          border-radius: 50%;
        }
      }
    }
  }
}
</style>
