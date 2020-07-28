import Auth from "../../../modules/ApiClient/Auth";
import form from "../form"

const state = () => ({
    data: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null
    }
});

const actions = {
    async submit({ dispatch }, { data }) {
        try {
            const response = await new Auth().register(data);
            return dispatch('form/onSuccess', { response });
        } catch (error) {
            return dispatch('form/onFail', { response: error });
        }
    }
}

const mutations = {
    reset() { }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    modules: { form }
}
