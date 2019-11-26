<template>
  <transition name="fade" mode="out-in">
    <router-view />
  </transition>
</template>

<script>
export default {
  layout: 'basic',
  middleware: 'auth',
  metaInfo () {
    return { title: this.$t('slide_point') }
  }
}
</script>
