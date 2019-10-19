import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import vuetify from '~/plugins/vuetify'
import swalPlugin from '~/plugins/sweetalert2';

import '~/plugins'
import '~/components'

Vue.prototype.$eventHub = new Vue()
Vue.config.productionTip = false
Vue.use(swalPlugin)
Vue.mixin({
  data: function() {
    return {
      get confirmDelete() {
      	let conf = {
		      title: 'Are you sure?',
		      type: 'warning',
		      showCancelButton: true,
		      confirmButtonColor: '#3085d6',
		      cancelButtonColor: '#d33',
		      confirmButtonText: 'Yes'      		
      	}
        return conf;
      }
    }
  }
})

/* eslint-disable no-new */
new Vue({
	vuetify,
  i18n,
  store,
  router,
  ...App
})
