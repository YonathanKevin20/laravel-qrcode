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
        this.encode = response.data;
      } catch (error) {
        console.error(error);
      }
    },
    close() {
      this.dialog = false;
    },
  }
}
</script>