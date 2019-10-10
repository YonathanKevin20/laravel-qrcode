<template>
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
    <v-container fluid>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $t('presences') }}</h2>
      </div>
      <transition name="fade" mode="out-in">
        <router-view />
      </transition>
    </v-container>  
  </main>
</template>

<script>
export default {
  layout: 'dashboard',
  middleware: 'auth',
}
</script>

<style>
[role="main"] {
  padding-top: 58px; /* Space for fixed navbar */
}
</style>
