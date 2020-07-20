import ApiClient from "../../modules/ApiClient/ApiClient";
import Cookbooks from "../../modules/ApiClient/Cookbooks";
import form from "./form";

const state = () => ({
    data: {}
});

const actions = {
    async show({ commit }, { id }) {
        const cookbook = await new Cookbooks().show(id);
        commit('set', { cookbook });
    },
    async store({ dispatch }, { data }) {
        try {
            const response = await new Cookbooks(true).store(data);
            const url = response.headers.location;
            const cookbook = await new ApiClient().get(url);
            dispatch('show', { id: cookbook.id });
        } catch (error) {
            return dispatch('form/onFail', { response: error });
        }
    }
}

const mutations = {
    set(state, { cookbook }) {
        state.data = cookbook;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    modules: { form }
}
