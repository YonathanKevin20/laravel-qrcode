<template>
  <v-app-bar app dark color="blue">
    <v-app-bar-nav-icon @click.stop="emitToParent"></v-app-bar-nav-icon>
    <v-toolbar-title>
      <router-link
        :to="{ name: user ? 'home' : 'welcome' }"
        class="white--text">{{ appName }}
      </router-link>
    </v-toolbar-title>

    <v-spacer></v-spacer>

    <!-- Authenticated -->
    <v-menu v-if="user" offset-y>
      <template v-slot:activator="{ on }">
        <a class="nav-link dropdown-toggle text-light" href="#" role="button" v-on="on">
          <img :src="user.photo_url" class="rounded-circle profile-photo mr-1"> {{ user.name }}
        </a>
      </template>
      <v-list flat dense>
        <v-list-item-group>
          <router-link :to="{ name: 'settings.profile' }">
            <v-list-item>
              <v-list-item-icon>
                <v-icon
                  :title="$t('settings')"
                  small>mdi-settings
                </v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>{{ $t('settings') }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </router-link>
          <v-divider style="margin: 0;"></v-divider>
          <a href="#" @click.prevent="logout">
            <v-list-item>
              <v-list-item-icon>
                <v-icon
                  :title="$t('logout')"
                  small>mdi-logout
                </v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title>{{ $t('logout') }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </a>
        </v-list-item-group>
      </v-list>
    </v-menu>
  </v-app-bar>
</template>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
</style>

<script>
import { mapGetters } from 'vuex'

export default {
  data: () => ({
    appName: window.config.appName,
    childDrawer: true,
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to welcome.
      this.$router.push({ name: 'welcome' })
    },
    emitToParent() {
      if(this.$vuetify.breakpoint.width >= 1264) {
        this.childDrawer = !this.childDrawer;
      }
      else {
        this.childDrawer = true;
      }
      this.$emit('clicked', this.childDrawer);
    }
  }
}
</script>
