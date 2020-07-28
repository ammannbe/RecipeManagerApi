import Foods from "../../modules/ApiClient/Foods";

const state = () => ({
    data: []
});

const actions = {
    async index({ commit }) {
        let foods = await new Foods().index();
        commit('set', { foods });
    }
}

const mutations = {
    set(state, { foods }) {
        state.data = foods;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
