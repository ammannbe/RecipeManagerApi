import Categories from "../../modules/ApiClient/Categories";

const state = () => ({
    categories: [],
});

const actions = {
    async index({ commit }) {
        let categories = await new Categories().index();
        commit('setCategories', categories);
    }
}

const mutations = {
    setCategories(state, categories) {
        state.categories = categories;
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
