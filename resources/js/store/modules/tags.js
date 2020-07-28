import Tags from "../../modules/ApiClient/Tags";

const state = () => ({
    data: [],
});

const actions = {
    async index({ commit }) {
        let tags = await new Tags().index();
        commit('set', { tags });
    }
}

const mutations = {
    set(state, { tags }) {
        state.data = tags;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
