import Units from "../../modules/ApiClient/Units";
import form from './form';

const state = () => ({
    data: []
});

const actions = {
    async index({ commit }, { trashed = false }) {
        let units = await new Units().index({ trashed });
        commit('set', { units });
    },
    async store({ dispatch }, { data }) {
        try {
            const response = await new Units().store(data);
            await dispatch('index');
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error.data });
        }
    },
    async update({ dispatch }, { id, data }) {
        try {
            await new Units().bulkUpdate(id, data);
            await dispatch('index', {});
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error.data });
        }
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
    mutations,
    modules: { form }
}
