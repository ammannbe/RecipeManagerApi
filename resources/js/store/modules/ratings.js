import LocalStorage from "../../modules/LocalStorage";
import Ratings from "../../modules/ApiClient/Ratings";

const state = () => ({
    hidden: LocalStorage.get("hide-ratings") == true || false,
    data: []
});

const actions = {
    async index({ commit }, { trashed = false, page = 1, filter = null, limit = 15, push = false }) {
        const ratings = await new Ratings().index({ trashed, page, limit, filter });
        if (push) {
            commit('pushRatings', { ratings });
        } else {
            commit('setRatings', { ratings });
        }
        return ratings;
    },
    async show({ state }, { id }) {
        return state.data.filter(rating => rating.id === id)[0];
    },
    async remove({ commit }, { id }) {
        await new Ratings().remove(id);
        commit('changeValue', { id, property: 'deleted_at', value: new Date().toJSON() });
    },
    async restore({ commit }, { id }) {
        await new Ratings().restore(id);
        commit('changeValue', { id, property: 'deleted_at', value: null });
    },
    toggleHidden({ state, commit }) {
        console.log(state.hidden);
        commit('setHidden', { hide: !state.hidden });
    }
}

const mutations = {
    setRatings(state, { ratings }) {
        state.data = ratings;
    },
    pushRatings(state, { ratings }) {
        if (!state.data.data) {
            state.data = ratings;
            return;
        }

        state.data.data.push(...ratings.data);
    },
    addRating(state, { rating }) {
        state.data.push(rating);
    },
    changeValue(state, { id, property, value }) {
        let index = state.data.data.findIndex((r => r.id == id));
        state.data.data[index][property] = value;
    },
    setHidden(state, { hide }) {
        state.hidden = hide;
        LocalStorage.set("hide-ratings", hide);
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
