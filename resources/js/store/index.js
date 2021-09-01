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
    deleteLoadingId: null,
    responseError: null,
    orderBy: 'desc',
    sortBy: 'id',
    search: null,
    searchResults: false,
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
    setDeleteLoadingId(state, deleteLoadingId) {
      state.deleteLoadingId = deleteLoadingId
    },
    setSearch(state, search) {
      state.search = search
    },
    setOrderBy(state, orderBy) {
      state.orderBy = orderBy
    },
    setSortBy(state, sortBy) {
      state.sortBy = sortBy
    },
    setSearchResults(state, searchResults) {
      state.searchResults = searchResults
    },
    setResponseError(state, error) {
      if (!error) {
        state.responseError = null
      } else {
        if (error.response) {
          const { data, status, config } = error.response
          switch (status) {
            case 400:
              if (typeof data == 'string') {
                state.responseError = data
              } else {
                state.responseError = 'Unknown error'
              }
              break
            case 422:
              state.responseError = data.message
              break
            case 404:
              state.responseError = 'Error: NOT FOUND'
              break
            case 500:
              state.responseError = 'Error: server-error'
              break
          }
        } else {
          state.responseError = 'Unknown error'
        }
      }
    },
  },
  actions: {
    async getBooks({ commit, state }, page = 1) {
      let extraString = ''
      if (state.search) {
        extraString += `&search=${state.search}`
      }
      if (state.orderBy) {
        extraString += `&order_by=${state.orderBy}`
      }
      if (state.sortBy) {
        extraString += `&sort_by=${state.sortBy}`
      }
      const url = `/api/books?page=${page}${extraString}`
      commit('setLoading', true)
      commit('setResponseError', null)
      if (state.search == null) commit('setSearchResults', false)
      try {
        const result = await axios.get(url)
        if (result.data) {
          result.data
          commit('setBooksData', result.data)
          if (result.data.data) {
            commit('setBooks', result.data.data)
          }
        }
        commit('setLoading', false)
        if (state.search) {
          commit('setSearchResults', true)
        }
      } catch (err) {
        console.log(err)
        commit('setBooksData', null)
        commit('setBooks', [])
        commit('setLoading', false)
        commit('setResponseError', err)
        throw err
      }
    },
    async createBook({ commit, state }, payload) {
      const url = '/api/book'
      commit('setFormLoading', true)
      commit('setResponseError', null)
      try {
        await axios.post(url, payload)
        commit('setFormLoading', false)
        return true
      } catch (err) {
        console.log(err)
        commit('setFormLoading', false)
        commit('setResponseError', err)
        throw err
      }
    },
    async deleteBook({ commit }, id) {
      if (!confirm('Sure delete?') || isNaN(id)) {
        return
      }
      commit('setDeleteLoadingId', id)
      const url = `/api/book/${id}`
      try {
        await axios.delete(url)
        commit('setDeleteLoadingId', id)
      } catch (err) {
        console.log(err)
        commit('setDeleteLoadingId', null)
        commit('setResponseError', err)
        throw err
      }
    },
    async getBook({ commit }, id) {
      const url = `/api/book/${id}`
      commit('setLoading', true)
      commit('setResponseError', null)
      try {
        const response = await axios.get(url)
        commit('setLoading', false)
        return response.data.data
      } catch (err) {
        console.log(err)
        commit('setLoading', false)
        commit('setResponseError', err)
        throw err
      }
    },
    async updateBook({ commit, state }, payload) {
        const url = `/api/book/${payload.id}`
        commit('setFormLoading', true)
        commit('setResponseError', null)
        try {
          await axios.put(url, payload)
          commit('setFormLoading', false)
          return true
        } catch (err) {
          console.log(err)
          commit('setFormLoading', false)
          commit('setResponseError', err)
          throw err
        }
      },
  },
})

export default store
