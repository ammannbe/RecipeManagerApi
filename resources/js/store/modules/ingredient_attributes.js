import IngredientAttributes from "../../modules/ApiClient/IngredientAttributes";

const state = () => ({
    data: []
});

const actions = {
    async index({ commit }) {
        let ingredientAttributes = await new IngredientAttributes().index();
        commit('set', { ingredientAttributes });
    },
    async store({ dispatch }, { data }) {
        try {
            const response = await new IngredientAttributes().store(data);
            await dispatch('index');
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error.data });
        }
    },
    async remove({ commit }, { id }) {
        await new IngredientAttributes().remove(id);
        commit('update', { id, property: 'deleted_at', value: new Date().toJSON() });
    },
    async restore({ commit }, { id }) {
        await new IngredientAttributes().restore(id);
        commit('update', { id, property: 'deleted_at', value: null });
    }
}

const mutations = {
    set(state, { ingredientAttributes }) {
        state.data = ingredientAttributes;
    },
    update(state, { id, property, value }) {
        let index = state.data.findIndex((r => r.id == id));
        state.data[index][property] = value;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
