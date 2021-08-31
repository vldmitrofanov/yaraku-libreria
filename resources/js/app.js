require('./bootstrap')

window.Vue = require('vue').default
import store from './store/index'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

// main layout
Vue.component('yaraku-app', require('./components/yaraku-app.vue').default)

//navigation
Vue.component('app-nav', require('./components/nav/index.vue').default)

// books components
Vue.component('books', require('./components/books/index.vue').default)

const app = new Vue({
  el: '#app',
  store,
})
