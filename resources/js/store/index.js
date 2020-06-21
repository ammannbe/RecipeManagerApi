import VuexReset from '@ianwalter/vuex-reset'
import Vuex from 'vuex'
import cookbook from './modules/cookbook'
import recipe from './modules/recipe'
import ingredient from './modules/ingredient'
import ingredient_group from './modules/ingredient_group'
import category from './modules/category'
import tag from './modules/tag'
import unit from './modules/unit'
import food from './modules/food'
import ingredient_attribute from './modules/ingredient_attribute'
import user from './modules/user'
import editmode from './modules/editmode'
import socialsharing from './modules/socialsharing'
import form from './modules/form'

const debug = process.env.APP_DEBUG;

export default new Vuex.Store({
    plugins: [VuexReset()],
    modules: {
        cookbook,
        recipe,
        ingredient,
        ingredient_group,
        category,
        tag,
        unit,
        food,
        ingredient_attribute,
        user,
        editmode,
        socialsharing,
        form
    },
    strict: debug,
})
