import Vue from 'vue';
import Vuex from 'vuex';

import users from './modules/users';
import user from './modules/user';

Vue.use(Vuex);

export default new Vuex.Store({
        modules: {
            users,
            user
        }
    }
);