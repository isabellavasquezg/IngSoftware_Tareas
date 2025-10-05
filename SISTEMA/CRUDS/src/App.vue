<template>
  <!-- <nav v-if="!isLoginPage">
    <router-link to="/listaU">Ver Ubicaciones</router-link>|
    <router-link to="/insertarU">Crear Ubicaciones</router-link>|
    <router-link to="/listaR">Ver Responsables</router-link>|
    <router-link to="/insertarR">Crear Responsables</router-link>|
    <router-link to="/listaE">Ver Equipos</router-link>|
    <router-link to="/insertarE">Crear Equipos</router-link>|
    <router-link to="/home">Inicio</router-link>
  </nav> -->
  <router-view/>
</template>

<script>
export default {
  computed: {
    isLoginPage() {
      return this.$route.name === 'login'; 
    }
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
