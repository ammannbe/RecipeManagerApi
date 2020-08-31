import errors from "./errors";

const state = () => ({
    data: null,
});

const actions = {
    update({ commit, state, getters }, { property, value, index = null }) {
        if (!getters.has(property)) {
            return false;
        }
        commit('errors/clear', { property });

        let data = state.data;
        if (index != null) {
            data[property][index] = value;
        } else {
            data[property] = value;
        }
        commit('set', { data });
    },
    async onSuccess({ commit }, { response }) {
        commit('errors/reset');
        commit('reset');

        return Promise.resolve(response);
    },
    async onFail({ commit }, { response }) {
        if (!response) {
            return;
        }

        let errors = response.errors;
        if (response.data) {
            errors = response.data.errors;
        }

        if (errors) {
            commit('errors/set', { data: errors });
        }

        return Promise.reject(response);
    }
}

const getters = {
    any: (state) => {
        return Object.keys(state.data || {}).length > 0;
    },
    has: (state, getters) => (property) => {
        if (!getters.any) {
            return false;
        }
        return state.data.hasOwnProperty(property);
    }
}

const mutations = {
    set(state, { data }) {
        state.data = data;
    },
    reset() { }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters,
    modules: { errors }
}
