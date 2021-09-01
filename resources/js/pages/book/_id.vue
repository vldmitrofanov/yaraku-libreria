<template>
  <b-overlay :show="loading" rounded="sm">
    <main class="container px-5">
      <h1>Editing Book ID: {{ $route.params.id }}</h1>
      <book-form
        ref="bookUpdateFormChild"
        @success="onSuccess"
        :book="book"
        v-if="book"
      ></book-form>
      <b-row>
        <b-col>
          <div class="float-right mb-3">
            <b-button variant="outline-secondary mr-1" @click="cancel">
              Cancel
            </b-button>
            <b-button variant="outline-primary" @click="handleOk">
              Save Changes
            </b-button>
          </div>
        </b-col>
      </b-row>
    </main>
  </b-overlay>
</template>
<script>
import { mapState, mapActions } from 'vuex'
export default {
  data() {
    return {
      book: null,
    }
  },
  computed: mapState({
    loading: (state) => state.loading,
    books: (state) => state.books,
  }),
  mounted() {
    const id = parseInt(this.$route.params.id)
    if(isNaN(id)){
        this.$router.push({ name: 'e404' })
        return
    }
    // check if we have local data
    if (this.books && this.books.length > 0) {
      this.books.forEach((v) => {
        if (parseInt(v.id) == id) {
          this.book = Object.assign(v, {})
        }
      })
    } else {
      this.getBook(id).then((v) => {
        console.log(v)
        this.book = Object.assign(v, {})
      }).catch(e=>{
          this.$router.push({ name: 'e404' })
      })
    }
  },
  methods: {
    ...mapActions(['getBook']),
    onSuccess(payload) {
      if (this.books && this.books.length > 0) {
        const books = JSON.parse(JSON.stringify(this.books))
        books.forEach((v, i) => {
          if (parseInt(v.id) == parseInt(payload.id)) {
            books[i] = payload
            this.$store.commit('setBooks', books)
          }
        })
      }
      this.$router.push({ name: 'books' })
    },
    handleOk(e) {
      e.preventDefault()
      this.$refs.bookUpdateFormChild.handleSubmit()
    },
    cancel() {
      this.$router.push({ name: 'books' })
    },
  },
}
</script>
