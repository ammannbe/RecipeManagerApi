import Foods from "../../modules/ApiClient/Foods";
import form from './form';

const state = () => ({
    data: []
});

const actions = {
    async index({ commit }, { trashed = false }) {
        let foods = await new Foods().index({ trashed });
        commit('set', { foods });
    },
    async store({ dispatch }, { data }) {
        try {
            const response = await new Foods().store(data);
            await dispatch('index');
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error.data });
        }
    },
    async update({ dispatch }, { id, data }) {
        try {
            await new Foods().bulkUpdate(id, data);
            await dispatch('index', {});
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error.data });
        }
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
    mutations,
    modules: { form }
}
