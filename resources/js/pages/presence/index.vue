<template>
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <v-container fluid>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $t('presence') }}</h2>
      </div>
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </v-container>  
  </main>
</template>

<style>
[role="main"] {
  padding-top: 58px; /* Space for fixed navbar */
}
</style>

<script>
export default {
  layout: 'dashboard',
  middleware: 'auth',
  metaInfo () {
    return { title: this.$t('presence') }
  }
}
</script>
