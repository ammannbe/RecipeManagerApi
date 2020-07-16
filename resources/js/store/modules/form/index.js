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
    push({ commit, state, getters }, { property, value }) {
        if (!getters.has(property)) {
            return false;
        }
        commit('errors/clear', { property });

        let data = state.data;
        data[property].push(value);
        commit('set', { data });
    },
    remove({ commit, state, getters }, { property, value }) {
        if (!getters.has(property)) {
            return false;
        }
        commit('errors/clear', { property });

        let data = state.data;
        data[property].splice(data[property].indexOf(value), 1);
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
    },
    // TODO: remove that stuff
    async submit({ commit, state, dispatch }, { func }) {
        try {
            const response = await func(state.data);
            if (!response) {
                return;
            }

            dispatch('onSuccess');
            return Promise.resolve(response);
        } catch (error) {
            if (!error) {
                return;
            }

            let errors = error.errors;
            if (error.data) {
                errors = error.data.errors;
            }

            if (errors) {
                commit('errors/set', { data: errors });
            }
            return Promise.reject(errors);
        }
    },
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
