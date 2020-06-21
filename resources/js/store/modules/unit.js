import Units from "../../modules/ApiClient/Units";

const state = () => ({
    units: []
});

const actions = {
    async index({ commit }) {
        let units = await new Units().index();
        commit('setUnits', units);
    }
}

const mutations = {
    setUnits(state, units) {
        state.units = units;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
