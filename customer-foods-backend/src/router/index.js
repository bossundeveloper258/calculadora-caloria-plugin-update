import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import LegacyCustomerFoods from '../views/LegacyCustomerFoods.vue'

Vue.use(VueRouter)

const routes = [
  {path: '/', name: 'Home', component: Home},
  {path: '/legacy_customer_foods', name: 'LegacyCustomerFoods', component: LegacyCustomerFoods},
]

const router = new VueRouter({
  routes
})

export default router
