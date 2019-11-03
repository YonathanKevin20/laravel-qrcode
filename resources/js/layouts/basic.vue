<template>
  <v-app id="scumbag">
    <v-content id="mando">
      <div class="basic-layout d-flex align-items-center justify-content-center m-0 bg-white">
        <child></child>
      </div>
    </v-content>
  </v-app>
</template>

<style lang="scss">
.basic-layout {
  color: #636b6f;
  height: 100vh;
  font-weight: 100;
  position: relative;

  .links > a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
  }
}
</style>

<script>
export default {
  name: 'BasicLayout'
}
</script>
