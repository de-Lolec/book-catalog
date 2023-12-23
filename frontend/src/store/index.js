import {createStore} from "vuex";

const store = createStore({
  state: {
    user: {
      data: {
        name: "Der",
        email: "fef",
      },
      token: null
    }
  },
  getters: {},
  actions: {},
  mutations: {},
  modules: {}
})

export default store;