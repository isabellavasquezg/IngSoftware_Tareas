import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import EditarR from '@/components/Responsables/EditarR.vue'
import EditarU from '@/components/Ubicaciones/EditarU.vue'
import InsertarR from '@/components/Responsables/InsetarR.vue'
import InsertarU from '@/components/Ubicaciones/InsetarU.vue'
import ListarR from '@/components/Responsables/ListaR.vue'
import ListarU from '@/components/Ubicaciones/ListaU.vue'
import EliminarR from '@/components/Responsables/EliminarR.vue'
import EliminarU from '@/components/Ubicaciones/EliminarU.vue'


const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/EditarU',
    name: 'EditarU',
    component: EditarU
  },
  {
    path: '/InsertarU',
    name: 'InsertarU',
    component:InsertarU
  },
  {
    path: '/EliminarU',
    name: 'EliminarU',
    component: EliminarU
  },
  {
    path: '/ListarU',
    name: 'ListarU',
    component: ListarU
  },
  {
    path: '/EditarR',
    name: 'EditarR',
    component: EditarR
  },
  {
    path: '/InsertarR',
    name: 'InsertarR',
    component:InsertarR
  },
  {
    path: '/EliminarR',
    name: 'EliminarR',
    component: EliminarR
  },
  {
    path: '/ListarR',
    name: 'ListarR',
    component: ListarR
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
