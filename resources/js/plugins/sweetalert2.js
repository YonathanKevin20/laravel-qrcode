import Vue from 'vue'
import Swal from 'sweetalert2'

const swalPlugin = {}

swalPlugin.install = function(Vue){
    Vue.prototype.$swal = Swal;
    Vue.prototype.$toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2400,
    });
}

export default swalPlugin