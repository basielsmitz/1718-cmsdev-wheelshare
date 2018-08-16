<template>
<div class="Reservation">
  <div class="header" :style='{background: "url(" + vehicle.field_image_url[0].value+ ")" }'>
    <div class="overlay">
      <static-header :title='getVehicleName'></static-header>

      <div class="dynamic">
        <div class="provider">
          <div class="left">
            <p>Aanbieder</p>
          </div>
          <div class="right">
            <router-link :to="{ name: 'Supplier', params: { supplierId: vehicle.id[0].value }}">
              {{vehicle.field_supplier.value}}
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <ul class="informationList">
      <li class="informationItem">
        <div class="left">
          <span>Van</span>
        </div>
        <div v-if="startDate" class="right">
          <span>{{getNormalDate(startDate)}}</span>
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          <span>Tot</span>
        </div>
        <div v-if="endDate" class="right">
          <span>{{getNormalDate(endDate)}}</span>
        </div>
      </li>
      <li class="InputItem informationItem">
        <div class="left">
          <span title="pickup">Ophalen:</span> <input title="pickup" id="pickup" v-model="startTime" type="time">
        </div>
        <div class="right">
          <span title="dropoff">Afzetten:</span> <input title="dropoff" id="dropoff" v-model="endTime" type="time">
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          <span>Aanbieder</span>
        </div>
        <div class="right">
          <span><router-link :to="{ name: 'Supplier', params: { supplierId: vehicle.field_supplier.id }}">{{vehicle.field_supplier.value}}</router-link></span>
        </div>
      </li>
    </ul>
    <div class="location">
      <h3>Ophaaal en afzet locatie</h3>
      <div class="map">
        <iframe width="100%" height="200" frameborder="0" style="border:0" :src="getGoogleMapSrc" allowfullscreen>
                    </iframe>
      </div>
      <div class="address">
        <p>{{vehicle.street}} {{vehicle.number}}</p>
        <p>{{vehicle.postal}} {{vehicle.city}}</p>
      </div>
    </div>
    <button type="button" class="mainButton" @click="confirmReservation">Bevestig</button>
  </div>
</div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import StaticHeader from "../partials/StaticHeader.vue"
import CookieMixin from '@/mixins/CookieMixin'
import VehicleMixin from '@/mixins/VehicleMixin'

export default {
  name: 'Reservation',
  components: {
    'static-header': StaticHeader,
  },
  mixins: [VehicleMixin, CookieMixin],
  data() {
    return {
      vehicle: this.$route.params.vehicle,
      startDate: null,
      endDate: null,
      startTime: "12:00",
      endTime: "12:00",
      userdata: this.getCookie('userData'),
      taxonomiesLoaded: false,
    }
  },
  methods: {
    getNormalDate(thedate) {
      let array = thedate.split("-");
      return array[2] + "/" + array[1] + "/" + array[0]
    },
    confirmReservation: function() {
      const data = {
        "data": {
          "type": "reservation--reservation",
          "attributes": {
            "name": "Reservation " + this.vehicle.field_merk.value + " " + this.vehicle.name[0].value,
            "status": true,
            "field_enddate": this.endDate + "T" + this.endTime + ":00",
            "field_startdate": this.startDate + "T" + this.startTime + ":00"
          },
          "relationships": {
            "field_supplier": {
              "data": {
                "type": "supplier--supplier",
                "id": this.vehicle.field_supplier.uuid,
              }
            },
            "field_vehicle": {
              "data": {
                "type": "vehicle--vehicle",
                "id": this.vehicle.uuid[0].value,
              }
            }
          }
        }
      }
      axios.post('http://drupal.dd:8083/jsonapi/reservation/reservation/', data, {
          headers: {
            'Content-Type': 'application/vnd.api+json',
            'Accept': 'application/vnd.api+json',
            'X-CSRF-Token': this.userdata.user.csrf_token,
            'Authorization': 'Basic ' + this.userdata.auth,
          }
        })
        .then(response => {
          this.$router.push({ name: 'Overview' });          
        })
        .catch(e => {
          console.log(e);
        })
    },
    setDates() {
      this.startDate = sessionStorage.getItem('startDate');
      this.endDate = sessionStorage.getItem('endDate');
    },

  },
  mounted() {
    if(!this.$route.params.vehicle){
      this.$router.push({ name: 'Overview' });
    } else {
      this.vehicle = this.$route.params.vehicle;
      this.setDates();
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
