import IngredientGroups from "../../modules/ApiClient/IngredientGroups";

const state = () => ({
    ingredientGroups: []
});

const actions = {
    async index({ commit }, { recipeId }) {
        let ingredientGroups = await new IngredientGroups().index({ recipeId });
        commit('setIngredientGroups', ingredientGroups);
    },
    async remove({ commit }, { id }) {
        // TODO: remove all in ingredient.js
        await new IngredientGroups(null).remove(id);
        commit('removeIngredientGroup', { id });
    },
}

const getters = {
    find: (state) => (id) => {
        return state.ingredientGroups.find((i => i.id == id));
    },
}

const mutations = {
    setIngredientGroups(state, ingredientGroups) {
        state.ingredientGroups = ingredientGroups;
    },
    removeIngredientGroup(state, { id }) {
        let index = state.ingredientGroups.findIndex((i => i.id == id));
        state.ingredientGroups.splice(index, 1);
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
