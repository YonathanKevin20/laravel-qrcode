<template>
  <mdb-container>
    <mdb-row>
    <mdb-col col="4">
      <mdb-card>
        <mdb-card-image src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20%286%29.jpg" alt="Card image cap"></mdb-card-image>
        <mdb-card-body>
          <mdb-card-title>{{ $t('home') }}</mdb-card-title>
          <mdb-card-text>{{ $t('you_are_logged_in') }}</mdb-card-text>
          <mdb-btn color="primary">Button</mdb-btn>
        </mdb-card-body>
      </mdb-card>
    </mdb-col>
    </mdb-row>
  </mdb-container>
</template>

<script>
import { mdbContainer, mdbRow, mdbCol, mdbCard, mdbCardImage, mdbCardBody, mdbCardTitle, mdbCardText, mdbBtn } from 'mdbvue';
export default {
  components: {
    mdbContainer,
    mdbRow,
    mdbCol,
    mdbCard,
    mdbCardImage,
    mdbCardBody,
    mdbCardTitle,
    mdbCardText,
    mdbBtn,
  },
  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('home') }
  }
}
</script>
