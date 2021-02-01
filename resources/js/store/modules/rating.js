import ApiClient from "../../modules/ApiClient/ApiClient";
import Ratings from "../../modules/ApiClient/Ratings";
import editmode from "./editmode";
import form from "./form";

const state = () => ({
    data: {}
});

const actions = {
    async show({ commit }, { id }) {
        let rating = await new Ratings().show(id);
        commit('setRating', { rating });
    },
    async update({ dispatch }, { id, data }) {
        try {
            const response = await new Ratings().bulkUpdate(id, data);
            dispatch('show', { id });
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error });
        }
    },
    async store({ dispatch }, { data }) {
        try {
            const response = await new Ratings().store(data);
            dispatch('show', { id: rating.id });
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error });
        }
    },
    async remove({ commit }, { id }) {
        commit('reset');
        await this.dispatch('ratings/remove', { id });
    }
}

const mutations = {
    setRating(state, { rating }) {
        state.data = rating;
    },
    reset() { }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    modules: { form }
}
