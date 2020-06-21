import Cookbooks from "../../modules/ApiClient/Cookbooks";

const state = () => ({
    cookbooks: []
});

const actions = {
    async index({ commit }, { trashed = false, page = null, limit = 15 }) {
        let cookbooks = await new Cookbooks().index({ trashed, page, limit });
        commit('setCookbooks', cookbooks);
    },
    async remove({ commit }, { id }) {
        await new Cookbooks().remove(id);
        commit('changeValue', { id, property: 'deleted_at', value: new Date().toJSON() });
    },
    async restore({ commit }, { id }) {
        await new Cookbooks().restore(id);
        commit('changeValue', { id, property: 'deleted_at', value: null });
    }
}

const mutations = {
    setCookbooks(state, cookbooks) {
        state.cookbooks = cookbooks;
    },
    changeValue(state, { id, property, value }) {
        let index = state.cookbooks.data.findIndex((r => r.id == id));
        state.cookbooks.data[index][property] = value;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
