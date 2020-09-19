import Cookbooks from "../../modules/ApiClient/Cookbooks";
import form from './form';

const state = () => ({
    data: { data: [] }
});

const actions = {
    async index({ commit }, { trashed = false, page = null, limit = 15 }) {
        let cookbooks = await new Cookbooks().index({ trashed, page, limit });
        commit('set', { cookbooks });
    },
    async update({ dispatch }, { id, property, value }) {
        await new Cookbooks().update(id, property, value);
        await dispatch('index');
    },
    async remove({ commit }, { id }) {
        await new Cookbooks().remove(id);
        commit('update', { id, property: 'deleted_at', value: new Date().toJSON() });
    },
    async restore({ commit }, { id }) {
        await new Cookbooks().restore(id);
        commit('update', { id, property: 'deleted_at', value: null });
    }
}

const mutations = {
    set(state, { cookbooks }) {
        state.data = cookbooks;
    },
    update(state, { id, property, value }) {
        let index = state.data.data.findIndex((r => r.id == id));
        state.data.data[index][property] = value;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    modules: { form }
}
