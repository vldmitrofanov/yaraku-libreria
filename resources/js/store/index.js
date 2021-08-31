import axios from 'axios'
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    books: [],
    booksData: null,
    loading: false,
    formLoading: false,
    error: null,
  },
  mutations: {
    setBooks(state, books) {
      state.books = books
    },
    setBooksData(state, booksData) {
      state.booksData = booksData
    },
    setLoading(state, loading) {
      state.loading = loading
    },
    setFormLoading(state, formLoading) {
        state.formLoading = formLoading
      },
    setError(state, error) {
      state.error = error
    },
  },
  actions: {
    async getBooks({ commit, state }, page = 1) {
      const url = `/api/books?page=${page}`
      commit('setLoading', true)
      commit('setError', null)
      try {
        const result = await axios.get(url)
        if (result.data) {
          result.data
          commit('setBooksData', result.data)
          if (result.data.data) {
            commit('setBooks', result.data.data)
          }
        }
        console.log(state.books)
        commit('setLoading', false)
      } catch (e) {
        console.log(e)
        commit('setLoading', false)
        const erMessage =
          e.response && e.response.data
            ? e.response.data.message
            : 'Server returned an unknown error :('
        commit('setError', erMessage)
      }
    },
  },
})

export default store
