<template>
  <b-overlay :show="formLoading" rounded="sm">
    <b-alert :show="responseError != null" variant="danger">
      {{ responseError }}
    </b-alert>
    <form ref="addBookForm" @submit.prevent="handleSubmit">
      <b-row class="my-3">
        <b-col sm="3" class="d-flex align-items-start">
          <label for="titleInput" class="mb-0">
            Title
            <code>*</code>
          </label>
        </b-col>
        <b-col sm="9">
          <b-form-input
            :state="$v.myBook.title.$error ? false : null"
            id="titleInput"
            v-model.trim="$v.myBook.title.$model"
            placeholder="Book title"
            required
          ></b-form-input>
          <div v-if="$v.myBook.title.$error" class="invalid-feedback">
            <span v-if="!$v.myBook.title.required">
              Title is required
            </span>
            <span v-if="!$v.myBook.title.maxLength">
              Title should not be longer than
              {{ $v.myBook.title.$params.maxLength.max }} characters.
            </span>
          </div>
        </b-col>
      </b-row>
      <b-row class="my-3">
        <b-col sm="3" class="d-flex align-items-start">
          <label for="authorInput" class="mb-0">
            Author
            <code>*</code>
          </label>
        </b-col>
        <b-col sm="9">
          <b-form-input
            :state="$v.myBook.author.$error ? false : null"
            id="authorInput"
            v-model.trim="$v.myBook.author.$model"
            placeholder="Book author"
            required
          ></b-form-input>
          <div v-if="$v.myBook.author.$error" class="invalid-feedback">
            <span v-if="!$v.myBook.author.required">
              Author is required
            </span>
            <span v-if="!$v.myBook.author.maxLength">
              Author name should not be longer than
              {{ $v.myBook.author.$params.maxLength.max }} characters.
            </span>
          </div>
        </b-col>
      </b-row>
      <b-row class="my-3">
        <b-col sm="3" class="d-flex align-items-start">
          <label for="authorInput" class="mb-0">
            Description
          </label>
        </b-col>
        <b-col sm="9">
          <b-form-textarea
            id="textarea"
            v-model="myBook.description"
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
const { required, maxLength } = require('vuelidate/lib/validators')
import { mapState, mapActions } from 'vuex'
export default {
  props: {
    book: {
      type: Object,
      required: false,
      default: () => null,
    },
  },
  data() {
    return {
      myBook: {
        title: '',
        author: '',
        description: '',
      },
    }
  },
  validations: {
    myBook: {
      title: {
        required,
        maxLength: maxLength(256),
      },
      author: {
        required,
        maxLength: maxLength(256),
      },
    },
  },
  computed: mapState({
    formLoading: (state) => state.formLoading,
    responseError: (state) => state.responseError,
  }),
  mounted() {
    if (this.book) {
      this.myBook = Object.assign(this.book, {})
    }
  },
  methods: {
    handleSubmit() {
      this.$v.$touch()
      if (this.$v.$invalid) {
        return
      }
      if (this.myBook.id) {
        this.$store
          .dispatch('updateBook', this.myBook)
          .then(() => this.$emit('success', this.myBook))
      } else {
        this.$store
          .dispatch('createBook', this.myBook)
          .then(() => this.$emit('success'))
      }
    },
  },
}
</script>
