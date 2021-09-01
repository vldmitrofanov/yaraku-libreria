<template>
  <div>
    <b-button @click="show = true">Export books</b-button>
    <b-modal title="Export Books to CSV or XML" v-model="show" @ok="handleOk">
      <b-form-group
        label="Select columns to export:"
        v-slot="{ ariaDescribedby }"
      >
        <b-form-checkbox-group
          :state="$v.columns.$error ? false : null"
          id="checkbox-columns"
          v-model="columns"
          :options="columnOptions"
          :aria-describedby="ariaDescribedby"
          name="columns"
        ></b-form-checkbox-group>
        <div
          v-if="$v.columns.$error"
          class="invalid-feedback"
          style="display: block;"
        >
          Please select at least one column to export
        </div>
      </b-form-group>

      <b-form-select
        v-model="export_type"
        :options="exportOptions"
      ></b-form-select>
    </b-modal>
  </div>
</template>
<script>
const { required, minLength } = require('vuelidate/lib/validators')
export default {
  data() {
    return {
      show: false,
      columns: ['title', 'author'],
      columnOptions: [
        { text: 'Title', value: 'title' },
        { text: 'Author', value: 'author' },
      ],
      export_type: 'csv',
      exportOptions: [
        { value: 'csv', text: 'Export as CSV' },
        { value: 'xml', text: 'Export as XML' },
      ],
    }
  },
  validations: {
    columns: {
      required,
      minLength: minLength(1),
    },
  },
  methods: {
    handleOk(e) {
      e.preventDefault()
      this.$v.$touch()
      if (this.$v.$invalid) {
        return
      }
      let url = `/api/books/export?export_type=${this.export_type}`
      this.columns.forEach((v) => {
        url += `&columns[]=${v}`
      })
      window.open(url, '_blank').focus()
    },
  },
}
</script>
