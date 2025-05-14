import { createRouter, createWebHistory } from 'vue-router'
import { routes } from 'vue-router/auto-routes'

export const router = createRouter({
  history: createWebHistory(),
  linkActiveClass: 'active',
  routes,
  
  // Router átirányítás után mindig az oldal tetejére irányítson.
  scrollBehavior(to, from, savedPosition) {
    return { top: 0}
  }
})