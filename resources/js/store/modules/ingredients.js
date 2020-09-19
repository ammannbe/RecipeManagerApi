import Ingredients from "../../modules/ApiClient/Ingredients";
import form from "./form";

const state = () => ({
    data: []
});

const actions = {
    async index({ commit }, { recipeId }) {
        let ingredients = await new Ingredients(recipeId).index();
        commit('set', { ingredients });
    },
    async update({ dispatch }, { id, recipeId, property, value }) {
        await new Ingredients().update(id, property, value);
        await dispatch('index', { recipeId });
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
    async remove({ commit }, { id, alternateId }) {
        await new Ingredients(null).remove(id);
        commit('remove', { id, alternateId });
    },
}

const getters = {
    grouped: (state) => {
        return state.data.reduce((r, a) => {
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
    set(state, { ingredients }) {
        state.data = ingredients;
    },
    remove(state, { id, alternateId }) {
        if (alternateId) {
            let index = state.data.findIndex(i => i.id == alternateId);
            let i = state.data[index].ingredients.findIndex(i => i.id == id);
            state.data[index].ingredients.splice(i, 1);
        } else {
            let index = state.data.findIndex((i => i.id == id));
            state.data.splice(index, 1);
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
