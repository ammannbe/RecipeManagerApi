import LocalStorage from "../../modules/LocalStorage";

const state = () => ({
    enabled: LocalStorage.get("edit-mode")
});

const actions = {
    toggle({ commit, state }) {
        commit('fire', { enable: !state.enabled });
    }
}

const mutations = {
    fire(state, { enable }) {
        if (!Laravel.isLoggedIn) {
            enable = false;
        }
        state.enabled = enable;
        LocalStorage.set("edit-mode", enable);
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
