<template>
  <nav>
    <router-link to="/">Home</router-link> |
    <router-link to="/ListarU">Ver Ubicaciones</router-link>|
    <router-link to="/InsertarU">Crear Ubicaciones</router-link>|
    <router-link to="/ListarR">Ver Responsables</router-link>|
    <router-link to="/InsertarR">Crear Responsables</router-link>

  </nav>
  <router-view/>
</template>

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
