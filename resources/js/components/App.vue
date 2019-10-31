<template>
  <v-app id="scumbag">
    <v-navigation-drawer
      app
      v-model="drawer">
      <sidebar-dashboard></sidebar-dashboard>
    </v-navigation-drawer>
    <navbar-dashboard @clicked="onClickChild"></navbar-dashboard>
    <loading ref="loading" />
    <v-content id="mando">
      <transition name="page" mode="out-in">
        <component :is="layout" v-if="layout" />
      </transition>
    </v-content>
  </v-app>
</template>

<script>
import NavbarDashboard from '~/components/NavbarDashboard'
import SidebarDashboard from '~/components/SidebarDashboard'
import Loading from './Loading'

// Load layout components dynamically.
const requireContext = require.context('~/layouts', false, /.*\.vue$/)

const layouts = requireContext.keys()
  .map(file =>
    [file.replace(/(^.\/)|(\.vue$)/g, ''), requireContext(file)]
  )
  .reduce((components, [name, component]) => {
    components[name] = component.default || component
    return components
  }, {})

export default {
  el: '#app',

  components: {
    NavbarDashboard,
    SidebarDashboard,
    Loading
  },

  data: () => ({
    layout: null,
    defaultLayout: 'default',
    drawer: null
  }),

  metaInfo () {
    const { appName } = window.config

    return {
      title: appName,
      titleTemplate: `%s · ${appName}`
    }
  },

  mounted () {
    this.$loading = this.$refs.loading
  },

  methods: {
    /**
     * Set the application layout.
     *
     * @param {String} layout
     */
    setLayout (layout) {
      if (!layout || !layouts[layout]) {
        layout = this.defaultLayout
      }

      this.layout = layouts[layout]
    },
    onClickChild(value) {
      this.drawer = value;
    }
  }
}
</script>
