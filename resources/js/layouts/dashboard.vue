<template>
  <v-app id="scumbag">
    <v-navigation-drawer
      app
      v-model="drawer">
      <sidebar-dashboard></sidebar-dashboard>
    </v-navigation-drawer>
    <navbar-dashboard @clicked="onClickChild"></navbar-dashboard>
    <v-content id="mando">
      <child></child>
    </v-content>
  </v-app>
</template>

<script>
import NavbarDashboard from '~/components/NavbarDashboard'
import SidebarDashboard from '~/components/SidebarDashboard'

export default {
  name: 'DashboardLayout',

  components: {
    NavbarDashboard,
    SidebarDashboard
  },

  data: () => ({
    drawer: null
  }),

  methods: {
    onClickChild(value) {
      this.drawer = value;
    }
  }
}
</script>
