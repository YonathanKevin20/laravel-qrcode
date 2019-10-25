import Vue from 'vue'
import Card from './Card'
import Child from './Child'
import Button from './Button'
import Checkbox from './Checkbox'
import FormImportPoint from './modals/FormImportPoint'
import FormChangePassword from './modals/FormChangePassword'
import FormEditPresence from './modals/FormEditPresence'
import QrCode from './modals/QrCode'
import { HasError, AlertError, AlertSuccess } from 'vform'

// Components that are registered globaly.
[
  Card,
  Child,
  Button,
  Checkbox,
  FormImportPoint,
  FormChangePassword,
  FormEditPresence,
  QrCode,
  HasError,
  AlertError,
  AlertSuccess
].forEach(Component => {
  Vue.component(Component.name, Component)
})
