import Foods from "../../modules/ApiClient/Foods";

const state = () => ({
    data: []
});

const actions = {
    async index({ commit }, { trashed = false }) {
        let foods = await new Foods().index({ trashed });
        commit('set', { foods });
    },
    async remove({ commit }, { id }) {
        await new Foods().remove(id);
        commit('update', { id, property: 'deleted_at', value: new Date().toJSON() });
    },
    async restore({ commit }, { id }) {
        await new Foods().restore(id);
        commit('update', { id, property: 'deleted_at', value: null });
    }
}

const mutations = {
    set(state, { foods }) {
        state.data = foods;
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
