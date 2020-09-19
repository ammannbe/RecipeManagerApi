import Users from "../../modules/ApiClient/Users";
import form from './form';

const state = () => ({
    data: { data: [] }
});

const actions = {
    async index({ commit }, { trashed = false }) {
        let users = await new Users().index({ trashed });
        commit('set', { users });
    },
    async store({ dispatch }, { data }) {
        try {
            const response = await new Users().store(data);
            await dispatch('index');
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error.data });
        }
    },
    async update({ dispatch }, { id, data }) {
        try {
            await new Users().bulkUpdate(id, data);
            await dispatch('index', {});
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error.data });
        }
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
    mutations,
    modules: { form }
}
