<template>
  <div>
    <div class="top-right links">
      <template v-if="authenticated">
        <router-link :to="{ name: 'home' }">
          {{ $t('home') }}
        </router-link>
      </template>
      <template v-else>
        <a href="#" @click="openLoginDialog">{{ $t('login') }}</a>
        <form-login></form-login>
        <!-- <router-link :to="{ name: 'login' }">
          {{ $t('login') }}
        </router-link> -->
      </template>
    </div>

    <div class="text-center">
      <div class="title mb-4">
        {{ title }}
      </div>
    </div>
  </div>
</template>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}
</style>

<script>
import { mapGetters } from 'vuex'

export default {
  layout: 'basic',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  methods: {
    openLoginDialog() {
      this.$eventHub.$emit('form-login', true);
    }
  }
}
</script>
