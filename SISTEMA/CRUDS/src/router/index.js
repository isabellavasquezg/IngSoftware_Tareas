import { createRouter, createWebHistory } from 'vue-router'
import EditarR from '@/components/Responsables/EditarR.vue'
import EditarU from '@/components/Ubicaciones/EditarU.vue'
import EditarE from '@/components/Equipos/EditarE.vue'
import InsertarR from '@/components/Responsables/InsertarR.vue'
import InsertarU from '@/components/Ubicaciones/InsertarU.vue'
import InsertarE from '@/components/Equipos/InsertarE.vue'
import ListaR from '@/components/Responsables/ListaR.vue'
import ListaU from '@/components/Ubicaciones/ListaU.vue'
import ListaE from '@/components/Equipos/ListaE.vue'
import LoginGeneral from '@/components/Usuarios/LoginGeneral.vue'
import HomeView from '@/views/HomeView.vue'



const routes = [
  {
    path: '/',
    name: 'login',
    component: LoginGeneral,
    meta: {
      hideNavbar: true 
    }
  },
  {
    path: '/editarU/:id',
    name: 'editarU',
    component: EditarU
  },
  {
    path: '/insertarU',
    name: 'insertarU',
    component:InsertarU
  },
  {
    path: '/listaU',
    name: 'listaU',
    component: ListaU
  },
  {
    path: '/editarR/:id',
    name: 'editarR',
    component: EditarR
  },
  {
    path: '/insertarR',
    name: 'insertarR',
    component:InsertarR
  },
  {
    path: '/listaR',
    name: 'listaR',
    component: ListaR
  },
  {
    path: '/editarE/:id',
    name: 'editarE',
    component: EditarE
  },
  {
    path: '/insertarE',
    name: 'insertarE',
    component:InsertarE
  },
  {
    path: '/listaE',
    name: 'listaE',
    component: ListaE
  },
  {
    path: '/home',
    name: 'home',
    component: HomeView
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
