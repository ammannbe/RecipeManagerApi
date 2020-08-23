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
    async index({ commit }, { trashed = false, only_own = false, page = 1, filter = null, limit = 15, push = false }) {
        let recipes = await new Recipes().index({ trashed, only_own, page, limit, ...filter });
        if (push) {
            commit('pushRecipes', { recipes });
        } else {
            commit('setRecipes', { recipes });
        }
        return recipes;
    },
    async show({ state }, { id }) {
        return state.data.filter(recipe => recipe.id === id)[0];
    },
    async remove({ state, commit }, { id, alreadyDeleted = false }) {
        await new Recipes().remove(id);

        if (state.data && state.data.length) {
            commit('changeValue', { id, property: 'deleted_at', value: new Date().toJSON() });
        }
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
    pushRecipes(state, { recipes }) {
        if (!state.data.data) {
            state.data = recipes;
            return;
        }

        state.data.data.push(...recipes.data);
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
