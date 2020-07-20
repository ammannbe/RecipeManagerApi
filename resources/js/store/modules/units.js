import Units from "../../modules/ApiClient/Units";

const state = () => ({
    data: []
});

const actions = {
    async index({ commit }) {
        let units = await new Units().index();
        commit('set', { units });
    }
}

const mutations = {
    set(state, { units }) {
        state.data = units;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
