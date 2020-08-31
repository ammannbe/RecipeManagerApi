import IngredientGroups from "../../modules/ApiClient/IngredientGroups";
import ApiClient from "../../modules/ApiClient/ApiClient";
import form from "./form";

const state = () => ({
    data: []
});

const actions = {
    async index({ commit }, { recipeId }) {
        let ingredientGroups = await new IngredientGroups(recipeId).index();
        commit('set', { ingredientGroups });
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
    async remove({ commit, rootGetters }, { id }) {
        await new IngredientGroups(null).remove(id);
        const ingredients = rootGetters['ingredients/byGroup'](id);
        ingredients.forEach(i => this.commit('ingredients/remove', { id: i.id }));
        commit('remove', { id });
    },
}

const getters = {
    find: (state) => (id) => {
        return state.data.find((i => i.id == id));
    },
}

const mutations = {
    set(state, { ingredientGroups }) {
        state.data = ingredientGroups;
    },
    remove(state, { id }) {
        let index = state.data.findIndex((i => i.id == id));
        state.data.splice(index, 1);
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
