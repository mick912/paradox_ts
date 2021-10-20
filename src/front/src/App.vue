<template>
  <div id="app">
    <div class='navbar'>
      <div class="container">
        <div class="row">
          <div class="column">
            <img class="logo" src="@/assets/logo.png"/>
          </div>
          <div class="column"></div>
        </div>
      </div>
    </div>
    <users-page></users-page>
  </div>
</template>

<script>

import UsersPage from "./pages/users.vue";

export default {
    components: {UsersPage},
    name: 'App'
}
</script>

<style>
  @import '~milligram';
  body {
    margin: 0
  }
</style>
<style scoped>
  .navbar {
    height: 60px;
    padding: 8px 0;
    margin-bottom: 15px;
    box-shadow: 2px 3px 4px rgb(140 143 152 / 10%), -2px 3px 4px rgb(140 143 152 / 10%);
  }
  .row, .container, .row * {
    height: 100%;
  }
</style>
