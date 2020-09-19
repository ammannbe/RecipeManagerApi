import VuexReset from '@ianwalter/vuex-reset'
import Vuex from 'vuex'
import cookbook from './modules/cookbook'
import cookbooks from './modules/cookbooks'
import recipe from './modules/recipe'
import recipes from './modules/recipes'
import ingredients from './modules/ingredients'
import ingredient_groups from './modules/ingredient_groups'
import ingredient_attributes from './modules/ingredient_attributes'
import categories from './modules/categories'
import tags from './modules/tags'
import units from './modules/units'
import foods from './modules/foods'
import user from './modules/user'
import users from './modules/users'
import editmode from './modules/editmode'
import socialsharing from './modules/socialsharing'
import form from './modules/form'

const debug = process.env.APP_DEBUG;

export default new Vuex.Store({
    plugins: [VuexReset()],
    modules: {
        cookbook,
        cookbooks,
        recipe,
        recipes,
        ingredients,
        ingredient_groups,
        categories,
        tags,
        units,
        foods,
        ingredient_attributes,
        user,
        users,
        editmode,
        socialsharing,
        form
    },
    strict: debug,
})
