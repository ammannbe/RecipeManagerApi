import Categories from "../../modules/ApiClient/Categories";
import form from './form';

const state = () => ({
    data: [],
});

const actions = {
    async index({ commit }, { trashed = false }) {
        let categories = await new Categories().index({ trashed });
        commit('set', { categories });
    },
    async store({ dispatch }, { data }) {
        try {
            const response = await new Categories().store(data);
            await dispatch('index');
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error.data });
        }
    },
    async update({ dispatch }, { id, data }) {
        try {
            await new Categories().bulkUpdate(id, data);
            await dispatch('index', {});
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error.data });
        }
    },
    async remove({ commit }, { id }) {
        await new Categories().remove(id);
        commit('update', { id, property: 'deleted_at', value: new Date().toJSON() });
    },
    async restore({ commit }, { id }) {
        await new Categories().restore(id);
        commit('update', { id, property: 'deleted_at', value: null });
    }
}

const mutations = {
    set(state, { categories }) {
        state.data = categories;
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
