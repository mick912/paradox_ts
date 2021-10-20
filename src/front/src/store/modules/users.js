import api from '../../api';
import config from '../../config';

export default {
    namespaced: true,
    state: () => ({
        results: [],
        currentPage: 1,
        firstPage: 1,
        lastPage: 1,
        pageSize: 15,
    }),
    mutations: {
        SET_USERS(state, data) {
            state.results = data.results;
            state.currentPage = data.current_page;
            state.firstPage = data.first_page;
            state.lastPage = data.last_page;
            state.pageSize = data.page_size;
        }
    } ,
    actions: {
        async getList({commit}, params) {
            const {data} = await api.get(config.users.list, {params});
            commit('SET_USERS', data);
        }
    },
    getters: {

    }
};