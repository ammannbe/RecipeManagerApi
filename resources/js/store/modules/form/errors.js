const state = () => ({
    data: {},
});

const actions = {}

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
    clear(state, { property }) {
        delete state.data[property];
    },
    reset() { }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
