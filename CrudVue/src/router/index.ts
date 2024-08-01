import { createRouter, createWebHistory } from 'vue-router'
import LayoutView from '@/views/layout/LayoutView.vue'
import HomeView from '@/views/home/HomeView.vue'
import PersonaView from '@/views/persona/PersonaView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'layout',
      component: LayoutView,
      children: [
        {
          path: '/',
          name: 'home',
          component: HomeView
        },
        {
          path: '/persona',
          name: 'persona',
          component: PersonaView
        }
      ]
    }
  ]
})

export default router
