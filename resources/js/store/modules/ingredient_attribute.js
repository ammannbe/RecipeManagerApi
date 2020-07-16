import IngredientAttributes from "../../modules/ApiClient/IngredientAttributes";

const state = () => ({
    data: []
});

const actions = {
    async index({ commit }) {
        let data = await new IngredientAttributes().index();
        commit('setIngredientAttributes', { data });
    }
}

const mutations = {
    setIngredientAttributes(state, { data }) {
        state.data = data;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
