<template>
  <div>
    <book-create></book-create>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th scope="col" style="width:10%">#</th>
          <th scope="col" style="width:30%">Title</th>
          <th scope="col">Author</th>
          <th scope="col" style="width:60px">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="book in books" :key="book.id">
          <th scope="row">{{ book.id }}</th>
          <td>{{ book.title }}</td>
          <td>{{ book.author }}</td>
          <td><b-button variant="danger"><b-icon icon="arrow-up"></b-icon></b-button></td>
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
  </div>
</template>
<script>
import { mapState, mapActions } from 'vuex'

export default {
  // ...
  computed: mapState({
    books: (state) => state.books,
    booksData: (state) => state.booksData,
    showPagination(){
        if(this.booksData && this.booksData.meta && this.booksData.meta.per_page < this.booksData.meta.total){
            return true
        }
        return false
    }
  }),
  mounted() {
    this.getBooks(1)
  },
  methods: {
    ...mapActions(['getBooks']),
  },
}
</script>
