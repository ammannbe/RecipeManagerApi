import Auth from "../../../modules/ApiClient/Auth";
import login from "./login";
import register from "./register";

const state = () => ({
    user: Laravel.user,
});

const actions = {
    login({ dispatch }, { data }) {
        return dispatch('login/submit', { data });
    },
    register({ dispatch }, { data }) {
        return dispatch('register/submit', { data });
    },
    async logout({ commit }) {
        await new Auth().logout();
        Laravel.isLoggedIn = false;
        commit('reset');
    }
}

const mutations = {
    setUser(state, user) {
        state.user = user;
    },
    reset() { }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    modules: { login, register }
}
