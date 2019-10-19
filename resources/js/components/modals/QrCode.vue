<template>
  <v-dialog v-model="dialog" max-width="700px">
    <v-card>
      <v-card-title>
        <span class="headline">{{ formTitle }}</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row
            :justify="'center'">
            <v-col cols="6">
              <v-responsive class="text-center">
                <v-progress-circular
                  v-if='!encode'
                  indeterminate
                  color="primary">
                </v-progress-circular>
              </v-responsive>
              <v-img
                v-if='encode'
                aspect-ratio="1"
                contain
                :src="'data:image/png;base64, '+encode">
              </v-img>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-btn
          :href="url_download"
          outlined
          color="blue">Download QR Code
        </v-btn>
        <div class="flex-grow-1"></div>
        <v-btn
          class="white--text"
          color="red"
          @click="close">{{ $t('cancel') }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import axios from 'axios'

export default {
  name: 'QrCode',

  props: ['id'],

  data: () => ({
    dialog: false,
    url_download: '',
    encode: '',
    name: '',
  }),

  computed: {
    formTitle() {
      return 'QR Code - '+this.name;
    },
  },

  watch: {
    dialog(val) {
      val || this.close()
    },
  },

  created() {
    let vm = this;
    this.$eventHub.$on('qr-code-'+this.id, function(item, value) {
      vm.url_download = base_api+'/child/download-qrcode/'+item.id,
      vm.getData();
      vm.name = item.name;
      vm.dialog = value;
    });
  },

  beforeDestroy() {
    this.$eventHub.$off('qr-code-'+this.id);
  },

  methods: {
    async getData() {
      try {
        const response = await axios.get('/api/child/generate-qrcode/'+this.id);
        if(response.data) {
          this.encode = response.data;
        }
        else {
          this.$toast.fire({
            type: 'error',
            title: 'Failed to Load'
          });
        }
      } catch (error) {
        this.$toast.fire({
          type: 'error',
          title: 'Failed to Load'
        });
        console.error(error);
      }
    },
    close() {
      this.dialog = false;
    },
  }
}
</script>