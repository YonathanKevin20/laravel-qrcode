<template>
  <v-dialog v-model="dialog" max-width="700px">
    <v-card>
      <v-card-title>
        <span class="headline">{{ formTitle }}</span>
      </v-card-title>
      <v-card-text>
        <v-container>
          <v-row>
            <v-col cols="12">
              <v-file-input
                outlined
                show-size
                label="File input"
                placeholder="Select your files"
                v-model="import_file"
                @change="handleFileUpload">
              </v-file-input>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-btn
          :href="url_download"
          outlined
          color="blue">Download Template
        </v-btn>
        <div class="flex-grow-1"></div>
        <v-btn
          class="white--text"
          color="red"
          @click="close">{{ $t('cancel') }}
        </v-btn>
        <v-btn
          class="white--text"
          color="green"
          :disabled="disabled"
          @click="submit">{{ $t('submit') }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<style>
  a:hover {
    text-decoration: none;
  }
</style>

<script>
import axios from 'axios'

export default {
  name: 'FormImportPoint',

  data: () => ({
    dialog: false,
    url_download: base_api+'/export/export-template-point',
    import_file: [],
    disabled: true,
  }),

  computed: {
    formTitle() {
      return 'Import File'
    },
  },

  watch: {
    dialog(val) {
      val || this.close()
    },
  },

  created() {
    let vm = this;
    this.$eventHub.$on('form-import-point', function(value) {
      vm.dialog = value;
    });
  },

  beforeDestroy() {
    this.$eventHub.$off('form-import-point');
  },

  methods: {
    async submit() {
      this.$toast.fire({
        type: 'info',
        title: 'File sedang di-import'
      });
      this.disabled = true;
      let formData = new FormData();
      formData.append('import_file', this.import_file);
      const { data } = await axios.post(base_api+'/import/point', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      if(data.success) {
        this.$eventHub.$emit('refresh-table', 'table-points');
        this.disabled = false;
        this.$toast.fire({
          type: 'success',
          title: 'Imported'
        });
      }
      else {
        this.$toast.fire({
          type: 'error',
          title: 'Failed'
        });
        console.log(data.console);
      }
      this.close();
    },
    close() {
      this.dialog = false;
      setTimeout(() => {
        this.clear();
      }, 300);
    },
    clear() {
      this.import_file = [];
      this.disabled = true;
    },
    handleFileUpload() {
      if(this.import_file) {
        this.disabled = false;
      }
      else {
        this.disabled = true;
      }
    },
  }
}
</script>