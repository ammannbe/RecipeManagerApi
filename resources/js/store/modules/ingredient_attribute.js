import IngredientAttributes from "../../modules/ApiClient/IngredientAttributes";

const state = () => ({
    ingredientAttributes: []
});

const actions = {
    async index({ commit }) {
        let ingredientAttributes = await new IngredientAttributes().index();
        commit('setIngredientAttributes', ingredientAttributes);
    }
}

const mutations = {
    setIngredientAttributes(state, ingredientAttributes) {
        state.ingredientAttributes = ingredientAttributes;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
