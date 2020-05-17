<template>
  <div class="edit-mode-switch">
    <label v-if="isLoggedIn" for="edit-mode">
      <div v-if="!enabled">
        <slot>Rezept bearbeiten</slot>
      </div>
      <div v-else>
        <slot>Bearbeiten beenden</slot>
      </div>
      <input @click="toggle()" :checked="enabled" name="edit-mode" id="edit-mode" type="checkbox" />
      <span class="switch round"></span>
    </label>
  </div>
</template>

<script>
import LocalStorage from "../../modules/LocalStorage";
import Auth from "../../modules/ApiClient/Auth";

export default {
  data() {
    return {
      enabled: false,
      isLoggedIn: false
    };
  },
  beforeMount() {
    const enable = JSON.parse(LocalStorage.get("edit-mode"));
    this.fire(enable);
  },
  mounted() {
    this.validateLogin();
    setInterval(() => {
      this.validateLogin();
    }, 60000);
  },
  methods: {
    validateLogin() {
      this.isLoggedIn = Auth.isValid();
      if (!this.isLoggedIn) {
        this.fire(false);
      }
    },
    toggle() {
      this.fire(!this.enabled);
    },
    fire(enable) {
      if (!Auth.isValid()) {
        enable = false;
      }
      this.enabled = enable;
      LocalStorage.set("edit-mode", enable);
      this.$emit("toggle", enable);
    }
  }
};
</script>

<style lang="scss" scoped>
.edit-mode-switch {
  > label {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;

    > div {
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
