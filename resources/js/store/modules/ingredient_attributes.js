import IngredientAttributes from "../../modules/ApiClient/IngredientAttributes";

const state = () => ({
    data: []
});

const actions = {
    async index({ commit }) {
        let ingredientAttributes = await new IngredientAttributes().index();
        commit('set', { ingredientAttributes });
    }
}

const mutations = {
    set(state, { ingredientAttributes }) {
        state.data = ingredientAttributes;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
