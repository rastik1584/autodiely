import Vue from 'vue';
import Vuex from 'vuex';
import car from "./modules/car";
import carPart from "./modules/carPart";
import api from "../api/car";

Vue.use(Vuex);
export default new Vuex.Store({
    state: {},
    getters: {},
    mutations: {},
    actions: {},
    modules: {
        car,
        carPart,
    }
})
