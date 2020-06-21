import LocalStorage from "../../modules/LocalStorage";

const state = () => ({
    enabled: !(LocalStorage.get("social-sharing") == false || false)
});

const actions = {
    hide({ commit }) {
        commit('fire', { enable: false });
    }
}

const mutations = {
    fire(state, { enable }) {
        state.enabled = enable;
        LocalStorage.set("social-sharing", enable);
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
