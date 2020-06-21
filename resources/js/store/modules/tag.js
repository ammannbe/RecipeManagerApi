import Tags from "../../modules/ApiClient/Tags";

const state = () => ({
    tags: [],
});

const actions = {
    async index({ commit }) {
        let tags = await new Tags().index();
        commit('setTags', tags);
    }
}

const mutations = {
    setTags(state, tags) {
        state.tags = tags;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
