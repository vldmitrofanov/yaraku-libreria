<template>
  <b-navbar toggleable="lg" type="dark" variant="info">
    <div class="container">
      <router-link :to="{ name: 'books' }">
        <b-navbar-brand>
          Yaraku Libreria App
        </b-navbar-brand>
      </router-link>
      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item><books-export></books-export></b-nav-item>
        </b-navbar-nav>
        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <b-nav-form>
            <b-form-input
              size="sm"
              class="mr-sm-2"
              placeholder="Search Author or Book"
              v-model="search"
            ></b-form-input>
            <b-button size="sm" class="my-2 my-sm-0" @click="runSearch">
              Search
            </b-button>
          </b-nav-form>
        </b-navbar-nav>
      </b-collapse>
    </div>
    
  </b-navbar>
</template>
<script>
export default {
  data() {
    return {
      search: null,
    }
  },
  methods: {
    runSearch() {
      console.log(this.search)
      if (this.search && this.search.length > 2) {
        this.$store.commit('setSearch', this.search)
        if (this.$route.name != 'books') {
          this.$router.push({ name: 'books' })
        } else {
          this.$store.dispatch('getBooks')
        }
      }
    },
  },
}
</script>
