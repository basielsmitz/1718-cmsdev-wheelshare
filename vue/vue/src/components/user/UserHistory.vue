<template>
<div class="UserHistory">
  <div class="header">
    <static-header :title="pageTitle"></static-header>

    <div class="dynamic">
      <div class="user">
        <div class="image"></div>
        <div class="name">{{getFullname}}</div>
        <div class="extra">
          <router-link :to="{ name: 'Supplier', params: { supplierId: user.field_supplier.id }}">
            Aanbiedersprofiel
          </router-link>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="reservations">
      <ul class="informationList">
        <li class="informationItem" v-for="reservation in user.field_reservations">
          <div class="left">
            {{ reservation.name }}

          </div>
          <div class="right">
            {{ getNormalDate(reservation.field_startdate) }} - {{ getNormalDate(reservation.field_enddate) }}
          </div>
        </li>
      </ul>
    </div>
  </div>
</div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import StaticHeader from "../partials/StaticHeader.vue"

export default {
  name: 'UserHistory',
  components: {
    'static-header': StaticHeader,
  },
  data() {
    return {
      pageTitle: 'Gebruiker',
      user: null,
    }
  },
  computed: {
    getFullname() {
      return this.user.field_voornaam[0].value + " " + this.user.field_naam[0].value
    }
  },
  methods: {
    getNormalDate(date) {
      let array = date.split("T");
      array = array[0].split("-");
      return array[2] + "/" + array[1] + "/" + array[0]
    },
  },
  created() {
    if(!this.$route.params.user){
      this.$router.push({ name: 'User' });
    } else {
      this.user = this.$route.params.user;
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
