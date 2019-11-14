<template>
  <v-container
    fill-height
    style="height: calc(100vh - 58px);">
    <v-layout align-center>
      <v-flex text-center>
        <h1 class="display-2 primary--text">Whoops, 404</h1>
        <p>The page you were looking for does not exist</p>
        <a @click="$router.push({ name: 'home' })">
          <v-btn
            outlined
            color="primary">Get me out of here!
          </v-btn>
        </a>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  name: 'NotFound',

  layout: 'basic',

  created () {
    this.$ssrContext && this.$ssrContext.res.status(404)
  }
}
</script>
