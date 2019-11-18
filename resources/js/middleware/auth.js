import store from '~/store'
import Swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

export default async (to, from, next) => {
  if(!store.getters['auth/check']) {
  	Swal.fire({
  		type: 'error',
  		title: i18n.t('error_alert_title'),
      text: 'Sorry, You must login first!',
      reverseButtons: true,
      confirmButtonText: i18n.t('ok'),
      cancelButtonText: i18n.t('cancel')
    }).then(() => {
    	next({ name: 'welcome' })
    })
  } else {
    next()
  }
}
