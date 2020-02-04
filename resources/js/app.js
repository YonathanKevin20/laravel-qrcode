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
Vue.mixin({
  data: () => ({
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
    },
  }),
  methods: {
    customDatetime(datetime) {
      let day = ('0'+datetime.getDate()).slice(-2);
      let month = ('0'+(datetime.getMonth()+1)).slice(-2);
      let hours = ('0'+datetime.getHours()).slice(-2);
      let minutes = ('0'+datetime.getMinutes()).slice(-2);
      let seconds = ('0'+datetime.getSeconds()).slice(-2);
      return day+'/'+month+' - '+hours+':'+minutes+':'+seconds;
    },
    humanDate(datetime) {
      let year = datetime.getFullYear();
      let month = ('0'+(datetime.getMonth()+1)).slice(-2);
      let day = ('0'+datetime.getDate()).slice(-2);
      return year+'-'+month+'-'+day;
    },
    humanTime(datetime) {
      let hours = ('0'+datetime.getHours()).slice(-2);
      let minutes = ('0'+datetime.getMinutes()).slice(-2);
      let seconds = ('0'+datetime.getSeconds()).slice(-2);
      return hours+':'+minutes+':'+seconds;
    }
  }
})

/* eslint-disable no-new */
new Vue({
	vuetify,
  i18n,
  store,
  router,
  swalPlugin,
  ...App
})
