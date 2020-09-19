import ApiClient from "../../modules/ApiClient/ApiClient";
import Recipes from "../../modules/ApiClient/Recipes";
import editmode from "./editmode";
import form from "./form";

const state = () => ({
    data: {},
    complexities: [
        {
            id: "simple",
            name: "Einfach"
        },
        {
            id: "normal",
            name: "Mittel"
        },
        {
            id: "difficult",
            name: "Schwierig"
        }
    ]
});

const actions = {
    async show({ commit }, { id }) {
        let recipe = await new Recipes().show(id);
        commit('setRecipe', { recipe });
    },
    async update({ dispatch }, { id, data }) {
        try {
            const response = await new Recipes().bulkUpdate(id, data);
            dispatch('show', { id });
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error });
        }
    },
    async addPhotos({ dispatch }, { id, photos }) {
        try {
            const response = await new Recipes().addPhotos(id, photos);
            dispatch('show', { id });
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error });
        }
    },
    async removePhoto({ dispatch }, { id, photo }) {
        try {
            const response = await new Recipes().removePhoto(id, photo);
            dispatch('show', { id });
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error });
        }
    },
    async store({ dispatch }, { data }) {
        try {
            const response = await new Recipes(true).store(data);
            const url = response.headers.location;
            const recipe = await new ApiClient().get(url);
            dispatch('show', { id: recipe.id });
            return dispatch('form/onSuccess', { response: recipe });
        } catch (error) {
            return dispatch('form/onFail', { response: error });
        }
    },
    async remove({ commit }, { id }) {
        commit('reset');
        await this.dispatch('recipes/remove', { id });
    },
    pdf({ state }) {
        return new Recipes().pdf(state.data.id);
    }
}

const mutations = {
    setRecipe(state, { recipe }) {
        recipe.complexity = state.complexities.filter(el => el.id === recipe.complexity)[0];

        if (recipe.preparation_time) {
            recipe.preparation_time = recipe.preparation_time.slice(0, -3);
        }

        if (!recipe.cookbook) {
            recipe.cookbook = { id: null, name: "Öffentlich" };
        }

        state.data = recipe;
    },
    reset() { }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    modules: { form, editmode }
}
