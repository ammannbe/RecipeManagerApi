import Categories from "../../modules/ApiClient/Categories";

const state = () => ({
    data: [],
});

const actions = {
    async index({ commit }) {
        let categories = await new Categories().index();
        commit('set', { categories });
    }
}

const mutations = {
    set(state, { categories }) {
        state.data = categories;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
