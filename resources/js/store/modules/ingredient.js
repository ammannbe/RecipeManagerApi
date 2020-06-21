import Ingredients from "../../modules/ApiClient/Ingredients";

const state = () => ({
    ingredients: []
});

const actions = {
    async index({ commit }, { recipeId }) {
        let ingredients = await new Ingredients(recipeId).index();
        commit('setIngredients', ingredients);
    },
    async remove({ commit }, { id, groupId, alternateId }) {
        await new Ingredients(null).remove(id);
        commit('removeIngredient', { id, groupId, alternateId });
    },
}

const getters = {
    grouped: (state) => {
        return state.ingredients.reduce((r, a) => {
            r[a.ingredient_group_id] = r[a.ingredient_group_id] || [];
            r[a.ingredient_group_id].push(a);
            return r;
        }, Object.create(null));
    },
    byGroup: (state, getters) => (id = null) => {
        return getters.grouped[id];
    }
}

const mutations = {
    setIngredients(state, ingredients) {
        state.ingredients = ingredients;
    },
    sort(state) {
        Object.keys(state.ingredients).forEach(key => {
            state.ingredients[key].sort((a, b) => a.position - b.position);
        });
    },
    remove(state, { id, alternateId }) {
        if (alternateId) {
            let index = state.ingredients.findIndex(i => i.id == alternateId);
            let i = state.ingredients[index].ingredients.findIndex(i => i.id == id);
            state.ingredients[index].ingredients.splice(i, 1);
        } else {
            let index = state.ingredients.findIndex((i => i.id == id));
            state.ingredients.splice(index, 1);
        }
    },
    changeValue(state, { id, alternateId, property, value }) {
        if (alternateId) {
            let index = state.ingredients.findIndex(i => i.id == alternateId);
            let i = state.ingredients[index].ingredients.findIndex(i => i.id == id);
            state.ingredients[index].ingredients[i][property] = value;
        } else {
            let index = state.ingredients.findIndex(i => i.id == id);
            state.ingredients[index][property] = value;
        }
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
