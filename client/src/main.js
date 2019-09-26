import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.config.productionTip = false
Vue.use(VueRouter)

import ListBooking from './components/ListBooking.vue'
import Auth from '@okta/okta-vue'

const routes = [
  { path: '/trivia', component: ListBooking }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

new Vue({
  router,
  render: h => h(ListBooking)
}).$mount('#app')