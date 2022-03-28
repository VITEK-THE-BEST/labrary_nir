import {createStore} from "vuex";

export default createStore({
    state: {
        token: '',
        isAuht: false,
    },
    mutations: {
        setToken(state, token) {
            state.token = token;
            state.isAuht = true;
        },
        dropToken(state) {
            state.token = '';
            state.isAuht = false;
        }
    },
    getters:{
        getIsAuth(state){
            return state.isAuht
        }
    },
    modules: {}
})
