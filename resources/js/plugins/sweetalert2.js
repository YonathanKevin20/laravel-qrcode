import Vue from 'vue'
import Swal from 'sweetalert2'

const swalPlugin = {}

swalPlugin.install = function(Vue){
    Vue.prototype.$swal = Swal;
    Vue.prototype.$toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
    });
}

export default swalPlugin