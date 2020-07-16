import Recipes from "../../modules/ApiClient/Recipes";

const state = () => ({
    data: [],
    complexities: [
        {
            id: "simple",
            name: "Einfach"
        },
        {
            id: "normal",
            name: "Mittel"
        },
        {
            id: "difficult",
            name: "Schwierig"
        }
    ]
});

const actions = {
    async index({ commit }, { trashed = false, page = 1, filter = null, limit = 15 }) {
        let recipes = await new Recipes().index({ trashed, page, filter, limit });
        commit('setRecipes', { recipes });
    },
    async show({ state }, { id }) {
        return state.data.filter(recipe => recipe.id === id)[0];
    },
    async remove({ commit }, { id }) {
        await new Recipes().remove(id);
        commit('changeValue', { id, property: 'deleted_at', value: new Date().toJSON() });
    },
    async restore({ commit }, { id }) {
        await new Recipes().restore(id);
        commit('changeValue', { id, property: 'deleted_at', value: null });
    }
}

const mutations = {
    setRecipes(state, { recipes }) {
        state.data = recipes;
    },
    addRecipe(state, { recipe }) {
        state.data.push(recipe);
    },
    changeValue(state, { id, property, value }) {
        let index = state.data.data.findIndex((r => r.id == id));
        state.data.data[index][property] = value;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
