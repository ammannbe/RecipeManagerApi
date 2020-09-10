import Tags from "../../modules/ApiClient/Tags";
import form from './form';

const state = () => ({
    data: [],
});

const actions = {
    async index({ commit }, { trashed = false }) {
        let tags = await new Tags().index({ trashed });
        commit('set', { tags });
    },
    async store({ dispatch }, { data }) {
        try {
            const response = await new Tags().store(data);
            await dispatch('index');
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error.data });
        }
    },
    async remove({ commit }, { id }) {
        await new Tags().remove(id);
        commit('update', { id, property: 'deleted_at', value: new Date().toJSON() });
    },
    async restore({ commit }, { id }) {
        await new Tags().restore(id);
        commit('update', { id, property: 'deleted_at', value: null });
    }
}

const mutations = {
    set(state, { tags }) {
        state.data = tags;
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
