<template>
  <v-container fluid>
    <v-row>
      <v-col cols="3">
        <v-card
          class="mx-auto"
          tile>
          <v-card-subtitle>{{ $t('settings') }}</v-card-subtitle>
          <v-list>
            <v-list-item-group v-model="item" color="primary">
              <v-list-item
                v-for="(tab, i) in tabs" :key="i"
                :to="{ name: tab.route }"
                link>
                <v-list-item-icon>
                  <v-icon>{{ tab.icon }}</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title>{{ tab.name }}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
          </v-list>
        </v-card>
      </v-col>
      <v-col cols="9">
        <transition name="fade" mode="out-in">
          <router-view />
        </transition>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  layout: 'dashboard',

  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    item: 0
  }),

  computed: {
    tabs() {
      return [
        {
          icon: 'mdi-account',
          name: this.$t('profile'),
          route: 'settings.profile'
        },
        {
          icon: 'mdi-lock',
          name: this.$t('password'),
          route: 'settings.password'
        }
      ]
    }
  }
}
</script>
