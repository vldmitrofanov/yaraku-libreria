require('./bootstrap')

window.Vue = require('vue').default
import store from './store/index'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import router from './router/index'
import VueRouter from 'vue-router'
import Vuelidate from 'vuelidate'

Vue.use(Vuelidate)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueRouter)

// pagination
Vue.component('pagination', require('laravel-vue-pagination'));

// main layout
Vue.component('yaraku-app', require('./components/yaraku-app.vue').default)

//navigation
Vue.component('app-nav', require('./components/nav/index.vue').default)

// books components
Vue.component('books', require('./components/books/index.vue').default)

Vue.component('book-create', require('./components/books/create.vue').default)

Vue.component('book-form', require('./components/books/form.vue').default)

const app = new Vue({
  el: '#app',
  store,
  router
})
