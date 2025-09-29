import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import EditarR from '@/components/Responsables/EditarR.vue'
import EditarU from '@/components/Ubicaciones/EditarU.vue'
import EditarE from '@/components/Equipos/EditarE.vue'
import InsertarR from '@/components/Responsables/InsetarR.vue'
import InsertarU from '@/components/Ubicaciones/InsetarU.vue'
import InsertarE from '@/components/Equipos/InsetarE.vue'
import ListarR from '@/components/Responsables/ListaR.vue'
import ListarU from '@/components/Ubicaciones/ListaU.vue'
import ListarE from '@/components/Equipos/ListaE.vue'
import EliminarR from '@/components/Responsables/EliminarR.vue'
import EliminarU from '@/components/Ubicaciones/EliminarU.vue'
import EliminarE from '@/components/Equipos/EliminarE.vue'



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
  {
    path: '/EditarE',
    name: 'EditarE',
    component: EditarE
  },
  {
    path: '/InsertarE',
    name: 'InsertarE',
    component:InsertarE
  },
  {
    path: '/EliminarE',
    name: 'EliminarE',
    component: EliminarE
  },
  {
    path: '/ListarE',
    name: 'ListarE',
    component: ListarE
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
