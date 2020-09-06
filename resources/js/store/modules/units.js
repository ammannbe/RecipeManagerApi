import Units from "../../modules/ApiClient/Units";

const state = () => ({
    data: []
});

const actions = {
    async index({ commit }, { trashed = false }) {
        let units = await new Units().index({ trashed });
        commit('set', { units });
    },
    async remove({ commit }, { id }) {
        await new Units().remove(id);
        commit('update', { id, property: 'deleted_at', value: new Date().toJSON() });
    },
    async restore({ commit }, { id }) {
        await new Units().restore(id);
        commit('update', { id, property: 'deleted_at', value: null });
    }
}

const mutations = {
    set(state, { units }) {
        state.data = units;
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
