import Recipes from "../../modules/ApiClient/Recipes";

const state = () => ({
    recipes: [],
    recipe: {},
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
    async index({ commit }, { trashed = false, page = 1, filter = null }) {
        let recipes = await new Recipes().index({ trashed, page, filter });
        commit('setRecipes', recipes);
    },
    async show({ commit }, { id }) {
        let recipe = await new Recipes().show(id);
        commit('setRecipe', recipe);
    },
    async remove({ commit, state }, { id }) {
        await new Recipes().remove(id);
        commit('changeValue', { id, property: 'deleted_at', value: new Date().toJSON() });
    },
    async restore({ commit, state }, { id }) {
        await new Recipes().restore(id);
        commit('changeValue', { id, property: 'deleted_at', value: null });
    }
}

const mutations = {
    setRecipes(state, recipes) {
        state.recipes = recipes;
    },
    setRecipe(state, recipe) {
        recipe.complexity = state.complexities.filter(
            complexity => complexity.id === recipe.complexity
        )[0];

        if (recipe.preparation_time) {
            recipe.preparation_time = recipe.preparation_time.slice(0, -3);
        }

        if (!recipe.cookbook) {
            recipe.cookbook = { id: null, name: "Öffentlich" };
        }

        state.recipe = recipe;
    },
    changeValue(state, { id, property, value }) {
        let index = state.recipes.data.findIndex((r => r.id == id));
        state.recipes.data[index][property] = value;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
