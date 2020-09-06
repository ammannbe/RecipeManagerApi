import Users from "../../modules/ApiClient/Users";

const state = () => ({
    data: { data: [] }
});

const actions = {
    async index({ commit }, { trashed = false }) {
        let users = await new Users().index({ trashed });
        commit('set', { users });
    },
    async remove({ commit }, { id }) {
        await new Users().remove(id);
        commit('update', { id, property: 'deleted_at', value: new Date().toJSON() });
    },
    async restore({ commit }, { id }) {
        await new Users().restore(id);
        commit('update', { id, property: 'deleted_at', value: null });
    }
}

const mutations = {
    set(state, { users }) {
        state.data = users;
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
