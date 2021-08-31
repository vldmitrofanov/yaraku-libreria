<template>
  <div class="float-right mb-3">
    <b-button variant="outline-primary" @click="show = true">Add book</b-button>
    <b-modal
      title="Add Book"
      v-model="show"
      @ok="handleOk"
      :ok-disabled="formLoading"
      :cancel-disabled="formLoading"
      :no-close-on-backdrop="formLoading"
      :no-close-on-esc="formLoading"
    >
      <book-form ref="bookFormChild" @success="onSuccess"></book-form>
    </b-modal>
  </div>
</template>
<script>
import { mapState, mapActions } from 'vuex'
export default {
  data() {
    return {
      show: false,
    }
  },
  computed: mapState({
    formLoading: (state) => state.formLoading,
  }),
  methods: {
    handleOk(bvModalEvt) {

      bvModalEvt.preventDefault()

      this.$refs.bookFormChild.handleSubmit()
    },
    onSuccess(){
        this.$store.dispatch('getBooks')
        this.show = false
    }
  },
}
</script>
