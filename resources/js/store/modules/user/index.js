import Auth from "../../../modules/ApiClient/Auth";
import login from "./login";
import register from "./register";
import password from "./password";
import Users from "../../../modules/ApiClient/Users";
import form from '../form';

const state = () => ({
    data: {}
});

const actions = {
    async show({ commit, dispatch }) {
        try {
            const response = await new Users().show();
            commit('set', { user: response });
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error });
        }
    },
    async login({ dispatch }, { data }) {
        return dispatch('login/submit', { data }).then(async () => await dispatch('show'));
    },
    register({ dispatch }, { data }) {
        return dispatch('register/submit', { data });
    },
    async logout({ commit }) {
        await new Auth().logout();
        commit('reset');
    }
}

const getters = {
    loggedIn: (state) => {
        return !!Object.keys(state.data).length;
    }
}

const mutations = {
    set(state, { user }) {
        state.data = user;
    },
    reset() { }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
    modules: { login, register, password, form }
}
