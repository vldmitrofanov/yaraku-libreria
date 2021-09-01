<template>
  <b-overlay :show="loading" rounded="sm">
    <div v-if="searchResults" class="d-flex mb-3">
      <h2 style="flex: 1 1 auto;">
        <b-icon icon="search"></b-icon>
        Search results for "{{ search }}"
      </h2>

      <b-button variant="outline-danger" @click="clearSearch">
        Clear search
      </b-button>
    </div>
    <book-create v-else></book-create>
    <b-alert :show="responseError != null" variant="danger">
      {{ responseError }}
    </b-alert>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th scope="col" style="width: 10%;">
            <a href="#" @click.stop.prevent="handleSortBy('id')">ID</a>
            <b-icon
              icon="sort-numeric-down"
              v-if="sortBy == 'id' && orderBy == 'asc'"
            />
            <b-icon
              icon="sort-numeric-down-alt"
              v-if="sortBy == 'id' && orderBy == 'desc'"
            />
          </th>
          <th scope="col" style="width: 30%;">
            <a href="#" @click.stop.prevent="handleSortBy('title')">Title</a>
            <b-icon
              icon="sort-alpha-down"
              v-if="sortBy == 'title' && orderBy == 'asc'"
            />
            <b-icon
              icon="sort-alpha-down-alt"
              v-if="sortBy == 'title' && orderBy == 'desc'"
            />
          </th>
          <th scope="col">
            <a href="#" @click.stop.prevent="handleSortBy('author')">Author</a>
            <b-icon
              icon="sort-alpha-down"
              v-if="sortBy == 'author' && orderBy == 'asc'"
            />
            <b-icon
              icon="sort-alpha-down-alt"
              v-if="sortBy == 'author' && orderBy == 'desc'"
            />
          </th>
          <th scope="col" style="width: 120px; gap: 4px;">
            Action
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="book in books" :key="book.id">
          <td scope="row">{{ book.id }}</td>
          <td>{{ book.title }}</td>
          <td>{{ book.author }}</td>
          <td class="d-flex" style="gap: 4px;">
            <b-button
              variant="danger"
              @click="handleDeleteBook(book.id)"
              :disabled="deleteLoadingId == book.id"
            >
              <b-spinner
                v-if="deleteLoadingId == book.id"
                style="width: 1rem; height: 1rem;"
              ></b-spinner>
              <b-icon v-else icon="trash-fill"></b-icon>
            </b-button>
            <router-link :to="{ name: 'book', params: { id: book.id } }">
              <b-button variant="primary">
                <b-icon icon="pencil-square"></b-icon>
              </b-button>
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>
    <pagination
      :data="booksData"
      @pagination-change-page="getBooks"
      align="right"
      :limit="1"
      v-if="showPagination"
    ></pagination>
    <div v-if="searchResults" class="d-flex mb-3">
      <span v-if="totalResults > 0">Results found {{ totalResults }}</span>
      <span v-else>Query returned 0 results</span>
    </div>
  </b-overlay>
</template>
<script>
import { mapState, mapActions } from 'vuex'

export default {
  // ...
  computed: mapState({
    loading: (state) => state.loading,
    books: (state) => state.books,
    search: (state) => state.search,
    booksData: (state) => state.booksData,
    sortBy: (state) => state.sortBy,
    orderBy: (state) => state.orderBy,
    searchResults: (state) => state.searchResults,
    deleteLoadingId: (state) => state.deleteLoadingId,
    responseError: (state) => state.responseError,
    showPagination() {
      if (
        this.booksData &&
        this.booksData.meta &&
        this.booksData.meta.per_page < this.booksData.meta.total
      ) {
        return true
      }
      return false
    },
    totalResults() {
      if (this.booksData && this.booksData.meta && this.booksData.meta.total) {
        return parseInt(this.booksData.meta.total)
      } else {
        return 0
      }
    },
  }),
  mounted() {
    if (!this.books || this.books.length == 0) this.getBooks(1)
  },
  methods: {
    ...mapActions(['getBooks', 'deleteBook']),
    clearSearch() {
      this.$store.commit('setSearch', null)
      this.getBooks(1)
    },
    handleDeleteBook(id) {
      this.deleteBook(id).then(() => this.getBooks(1))
    },
    handleSortBy(string) {
      if (string != this.sortBy) {
        this.$store.commit('setSortBy', string)
        this.$store.commit('setOrderBy', 'asc')
      } else {
        const ob = this.orderBy == 'desc' ? 'asc' : 'desc'
        this.$store.commit('setOrderBy', ob)
      }
      this.getBooks(1)
    },
  },
}
</script>
