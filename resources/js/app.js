import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import vuetify from '~/plugins/vuetify'
import swalPlugin from '~/plugins/sweetalert2';

import '~/plugins'
import '~/components'

Vue.config.productionTip = false
Vue.use(swalPlugin)

/* eslint-disable no-new */
new Vue({
	vuetify,
  i18n,
  store,
  router,
  ...App
})
