import { getField, updateField } from 'vuex-map-fields';

const state = () => ({
    data: {},
    errors: {},
});

const actions = {
    async onSuccess({ commit }, { response }) {
        commit('reset');

        return Promise.resolve(response);
    },
    async onFail({ commit }, { response }) {
        if (!response) {
            return;
        }

        let errors = response.errors;
        if (response.data) {
            errors = response.data.errors;
        }

        if (errors) {
            commit('setErrors', { errors });
        }

        return Promise.reject(response);
    }
}

const getters = {
    getFormFields(state) {
        return getField(state.data);
    }
}

const mutations = {
    updateFormFields(state, field) {
        delete state.errors[field.path];

        if (field.path === 'email') {
            delete state.errors['password'];
        }

        if (field.path === 'password') {
            delete state.errors['email'];
            delete state.errors['password_confirmation'];
        }

        if (field.path === 'password_confirmation') {
            delete state.errors['password'];
        }

        updateField(state.data, field);
    },
    setErrors(state, { errors }) {
        state.errors = errors;
    },
    reset() { }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters
}
