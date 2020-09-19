import Auth from "../../../modules/ApiClient/Auth";
import form from "../form"

const state = () => ({
    data: {
        email: null,
        password: null
    }
});

const actions = {
    async submit({ dispatch }, { data }) {
        try {
            const response = await new Auth().login(data);
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
