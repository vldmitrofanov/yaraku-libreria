<template>
  <b-overlay :show="formLoading" rounded="sm">
    <form ref="addBookForm">
      <b-row class="my-3">
        <b-col sm="3" class="d-flex align-items-center">
          <label for="titleInput" class="mb-0">
            Title
            <code>*</code>
          </label>
        </b-col>
        <b-col sm="9">
          <b-form-input
            id="titleInput"
            v-model="newBook.title"
            placeholder="Book title"
            required
          ></b-form-input>
        </b-col>
      </b-row>
      <b-row class="my-3">
        <b-col sm="3" class="d-flex align-items-center">
          <label for="authorInput" class="mb-0">
            Author
            <code>*</code>
          </label>
        </b-col>
        <b-col sm="9">
          <b-form-input
            id="authorInput"
            v-model="newBook.title"
            placeholder="Book author"
            required
          ></b-form-input>
        </b-col>
      </b-row>
      <b-row class="my-3">
        <b-col sm="3" class="d-flex align-items-center">
          <label for="authorInput" class="mb-0">
            Description
          </label>
        </b-col>
        <b-col sm="9">
          <b-form-textarea
            id="textarea"
            v-model="newBook.description"
            placeholder="Book description (optional)..."
            rows="3"
            max-rows="6"
          ></b-form-textarea>
        </b-col>
      </b-row>
    </form>
  </b-overlay>
</template>
<script>
import { mapState, mapActions } from 'vuex'
export default {
  data() {
    return {
      newBook: {
        title: '',
        author: '',
        description: '',
      },
    }
  },
  computed: mapState({
    formLoading: (state) => state.formLoading,
  }),
  methods: {
    handleSubmit() {
      this.$store.commit('setFormLoading', true)
      console.log(this.formLoading)
      console.log('ok')
    },
  },
}
</script>
