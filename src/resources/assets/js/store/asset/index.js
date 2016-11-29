import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const state = {
    count: 0,
    query: ''
};

const mutations = {
    increment(state) {
        state.count++;
    },

    decrement(state) {
        state.count--;
    }
};

const actions = {
    increment: ({ commit }) => commit('increment'),
    decrement: ({ commit }) => commit('decrement')
};

const getters = {

};

export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations
})