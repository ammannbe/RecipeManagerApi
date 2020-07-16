import Ingredients from "../../modules/ApiClient/Ingredients";
import form from "./form";

const state = () => ({
    ingredients: []
});

const actions = {
    async index({ commit }, { recipeId }) {
        let ingredients = await new Ingredients(recipeId).index();
        commit('setIngredients', ingredients);
    },
    async update({ dispatch }, { id, recipeId, property, value }) {
        try {
            await new Ingredients().update(id, property, value);
            await dispatch('index', { recipeId });
        } catch (error) { }
    },
    async store({ dispatch }, { recipeId, data }) {
        try {
            const response = await new Ingredients(recipeId).store(data);
            await dispatch('index', { recipeId });
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error.data });
        }
    },
    async remove({ commit }, { id, groupId, alternateId }) {
        await new Ingredients(null).remove(id);
        commit('remove', { id, groupId, alternateId });
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
    addIngredient(state, { ingredient }) {
        state.ingredients.push(ingredient);
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
    getters,
    modules: { form }
}
