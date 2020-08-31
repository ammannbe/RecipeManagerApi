import Auth from "../../../modules/ApiClient/Auth";
import form from "../form"

const state = () => ({
    data: {
        email: null,
        password: null,
        password_confirmation: null
    }
});

const actions = {
    async forgot({ dispatch }, { email }) {
        return new Auth().forgotPassword({ email }).then((response) => {
            return dispatch('form/onSuccess', { response });
        }).catch((err) => {
            return dispatch('form/onFail', { response: err });
        });
    },
    async reset({ dispatch }, { token, email, password, password_confirmation }) {
        return new Auth().resetPassword({ token, email, password, password_confirmation }).then((response) => {
            return dispatch('form/onSuccess', { response });
        }).catch((err) => {
            return dispatch('form/onFail', { response: err });
        });
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
