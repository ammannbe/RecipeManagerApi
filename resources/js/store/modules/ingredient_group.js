import IngredientGroups from "../../modules/ApiClient/IngredientGroups";
import ApiClient from "../../modules/ApiClient/ApiClient";
import form from "./form";

const state = () => ({
    ingredientGroups: []
});

const actions = {
    async index({ commit }, { recipeId }) {
        let ingredientGroups = await new IngredientGroups(recipeId).index();
        commit('setIngredientGroups', ingredientGroups);
    },
    async store({ dispatch }, { recipeId, name }) {
        try {
            const response = await new IngredientGroups(recipeId, true).store({ name });
            const url = response.headers.location;
            dispatch('index', { recipeId });
            dispatch('form/onSuccess', { response: response.data });
            return (await new ApiClient().get(url)).id;
        } catch (error) {
            return dispatch('form/onFail', { response: error.response });
        }
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
    getters,
    modules: { form }
}
