<template>
  <v-container fluid>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h2>{{ $t('children') }}</h2>
    </div>
    <transition name="fade" mode="out-in">
      <router-view />
    </transition>
  </v-container>
</template>

<script>
export default {
  layout: 'dashboard',
  middleware: 'auth',
  metaInfo () {
    return { title: this.$t('children') }
  }
}
</script>
