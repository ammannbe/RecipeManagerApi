import Users from "../../modules/ApiClient/Users";
import Auth from "../../modules/ApiClient/Auth";

const state = () => ({
    user: Laravel.user,
});

const actions = {
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
    mutations
}
