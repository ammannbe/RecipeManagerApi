import Foods from "../../modules/ApiClient/Foods";

const state = () => ({
    foods: []
});

const actions = {
    async index({ commit }) {
        let foods = await new Foods().index();
        commit('setFoods', foods);
    }
}

const mutations = {
    setFoods(state, foods) {
        state.foods = foods;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
