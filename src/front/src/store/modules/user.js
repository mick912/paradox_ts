import api from '../../api';
import config from '../../config';

export default {
    namespaced: true,

    state: () => ({
        user: {},
    }),
    mutations: {
        SET_USER(state, data) {
            state.user = data;
        }
    } ,
    actions: {
        async retrieve({commit}, param) {
            let url = config.users.retrieve.replace(new RegExp('{id}', 'g'), param.id);
            const {data} = await api.get(url);
            commit('SET_USER', data);
        }
    },
    getters: {

    }
};