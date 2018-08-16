<template>
<div class="User">
  <div class="header">
    <static-header :title="pageTitle"></static-header>
    <div class="dynamic">
      <div v-if="user" class="user">
        <div class="image"></div>
        <div class="name">{{getFullname}}</div>
        <div v-if="supplierLoaded" class="extra">
          <router-link :to="{ name: 'Supplier', params: { supplierId: user.field_supplier.id }}">
            Aanbiedersprofiel
          </router-link>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <div v-if="user" class="userInfo">
      <ul class="informationList">
        <li class="informationItem">
          <div class="left">
            Naam
          </div>
          <div class="right">
            {{getFullname}}
          </div>
        </li>
        <li class="informationItem">
          <div class="left">
            Geslacht
          </div>
          <div class="right">
            {{user.field_gel[0].value}}
          </div>
        </li>
        <li class="informationItem">
          <div class="left">
            Geboortedatum
          </div>
          <div class="right">
            {{getNormalDate(user.field_geboortedatum[0].value)}}
          </div>
        </li>
        <li class="informationItem">
          <div class="left">
            Locatie
          </div>
          <div class="right">
            {{user.field_gemeente[0].value}}
          </div>
        </li>
        <li class="informationItem">
          <div class="left">
            Aanbieder
          </div>
          <div class="right">
            <router-link :to="{ name: 'Supplier', params: { supplierId: user.field_supplier.id }}">
              Aanbiedersprofiel
            </router-link>
          </div>
        </li>
      </ul>
      <router-link class="secondaryButtonLink" :to="{ name: 'UserDetail', params: {user: user}}"><button class="secondaryButton" type="button">Meer</button></router-link>
    </div>
    <div>
      <h3>Reservaties</h3>
      <div v-if="reservations && user" class="reservations">
        <ul class="informationList">
          <li class="informationItem" v-for="reservation in user.field_reservations.slice(0, 5)">
            <div class="left">
              {{ reservation.name }}
            </div>
            <div class="right">
              {{ getNormalDate(reservation.field_startdate) }} - {{ getNormalDate(reservation.field_enddate) }}
            </div>
          </li>
        </ul>
        <router-link class="secondaryButtonLink" :to="{ name: 'UserHistory', params: {user: user} }"><button class="secondaryButton" type="button">Meer</button></router-link>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import StaticHeader from "../partials/StaticHeader.vue"
import CookieMixin from '@/mixins/CookieMixin'
import DataMixin from '@/mixins/DataMixin'
import ReservationMixin from '@/mixins/ReservationMixin'

export default {
  name: 'User',
  mixins: [CookieMixin, DataMixin, ReservationMixin],
  components: {
    'static-header': StaticHeader,
  },
  data() {
    return {
      pageTitle: 'Gebruiker',
      user: null,
      userdata: this.getCookie('userData'),
      supplierLoaded: false,
      reservationsLoaded: false,
    }
  },
  computed: {
    getFullname() {
      return this.user.field_voornaam[0].value + " " + this.user.field_naam[0].value
    }
  },
  methods: {
    getNormalDate(thedate) {
      const date = thedate.split("T")[0];
      let array = date.split("-");
      return array[2] + "/" + array[1] + "/" + array[0]
    },
    getUserData() {
      axios.get('http://drupal.dd:8083/user/' + this.userdata.user.current_user.uid + '?_format=json', {
          headers: {
            'Content-Type': 'application/hal+json',
            'X-CSRF-Token': this.userdata.user.csrf_token,
            'Authorization': 'Basic ' + this.userdata.auth,
          }
        })
        .then(response => {
          console.log('test');
          console.log(response);
          this.user = response.data;
          this.getsupplierInfo(this.user.field_supplier[0].target_id, "field_supplier", false, this.user);
          this.supplierLoaded = true;

          console.log(this.user.uid[0].value);
          console.log(this.reservations[0].user_id);
          console.log(this.user.field_reservations);
          this.user.field_reservations = this.reservations.filter(reservation => reservation.user_id == this.user.uid[0].value);
          // let index = 0;
          // const self = this;
          // console.log(this.user.field_reservations);
          // console.log(this.reservations);
          // this.user.field_reservations.forEach(function(element) {
            // console.log(element).target_id;
            //
            //
            // if (index === 5) {
            //   return false;
            // } else {
            //   self.user.field_reservations[index] = self.getReservation(element.target_uuid);
            //   if (index === self.user.field_reservations.length - 1) {
            //     self.reservationsLoaded = true;
            //   }
            //   index++;
            // }
          // });
        })
        .catch(e => {
          console.log(e)
        })
    },
  },
  mounted() {
    this.getReservations(true);
  }
}
</script>


<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
