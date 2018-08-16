<template>
<div class="Overview">
  <div class="header">
    <static-header :title="pageTitle"></static-header>
    <div class="dynamic">
      <form class="filters">
        <div class="row">
          <div class="inputGroup left">
            <label>Van</label>
            <input @change="changeStart" :min="startDate" v-model="startDate" type="date" title="startDate" id="startDate" />
          </div>
          <div class="inputGroup right">
            <label>Tot</label>
            <input @change="changeEnd" :min="startDate" v-model="endDate" type="date" title="endDate" id="endDate" />
          </div>
        </div>
        <div class="row">
          <div class="left">
            <select v-model="location" title="location" id="location">
                                <option value="Gent">Gent</option>
                                <option value="Brugge">Brugge</option>
                            </select>
            <select v-model="type" title="type" id="type">
                                <option value="Wagen">Wagen</option>
                                <option value="Motor">Motor</option>
                                <option value="Scooter">Scooter</option>
                            </select>
          </div>
          <div class="right">
            <input type="search" name="search" placeholder="Zoek" v-model="search" id="search">
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="content">
    <div class="container">
      <div class="listOfVehicles">
        <vehicle-item v-for="vehicle in filteredVehicles" :key="vehicle.id" :id="vehicle.id" :model="vehicle.name" :imageUrl="vehicle.field_image_url" :type="vehicle.field_type" :brand="vehicle.field_merk" :location="vehicle.field_gemeente">
        </vehicle-item>
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
import VehicleItem from "../partials/VehicleItem.vue"
import CookieMixin from '@/mixins/CookieMixin'
import VehicleMixin from '@/mixins/VehicleMixin'
import ReservationMixin from '@/mixins/ReservationMixin'


let moment = require('moment');
import VueLocalStorage from 'vue-localstorage'

Vue.use(VueLocalStorage)

export default {
  name: 'Overview',
  mixins: [CookieMixin, VehicleMixin, ReservationMixin],
  components: {
    VehicleItem,
    'static-header': StaticHeader,
    'vehicle-item': VehicleItem,
  },

  data() {
    return {
      pageTitle: 'Overzicht voertuigen',
      // fiteredVehicles,
      startDate: moment().format("YYYY-MM-DD"),
      endDate: moment().add(1, 'days').format("YYYY-MM-DD"),
      location: 'Gent',
      type: 'Wagen',
      search: '',
      unavailableVehicles: null,
    }
  },
  computed: {
    filteredVehicles() {
      if(this.vehicles && this.unavailableVehicles) {
        let result = this.vehicles
        .filter(
          vehicle => vehicle.field_gemeente.toLowerCase() === this.location.toLowerCase()
        ).filter(
          vehicle => vehicle.field_type.toLowerCase() === this.type.toLowerCase()
        ).filter(
          vehicle => !this.unavailableVehicles.includes(vehicle.id)
        );
        if(this.search.trim() !== ''){
          this.search.split(" ").forEach(term => {
            result = result.filter(vehicle =>
              vehicle.field_merk.toLowerCase().includes(term.toLowerCase().trim()) ||
              vehicle.name.toLowerCase().includes(term.toLowerCase().trim())
            )
          });
        }
        return result;
      }
    }
  },
  methods: {
    filterReservations() {
      const start = new Date(this.startDate).getTime();
      const end = new Date(this.endDate).getTime();
      if(this.reservations) {
        const unavailable = this.reservations.filter(reservation =>
          (start >= new Date(reservation.field_startdate.split('T')[0]).getTime()  && start <= new Date(reservation.field_enddate.split('T')[0]).getTime()) ||
          (end >= new Date(reservation.field_startdate.split('T')[0]).getTime()  && end <= new Date(reservation.field_enddate.split('T')[0]).getTime()) ||
          (start <= new Date(reservation.field_startdate.split('T')[0]).getTime()  && end >= new Date(reservation.field_enddate.split('T')[0]).getTime())
        );
        this.unavailableVehicles = [];
        unavailable.forEach(reservation => {
          this.unavailableVehicles.push(reservation.field_vehicle);
        })
      }

    },
    changeStart() {
      this.filterReservations();
      //                let now = new moment().format("YYYY-MM-DD");
      //                if (this.startDate < now) {
      //                    this.startDate = now;
      this.storeDates();
      //                }
    },
    changeEnd() {
      this.filterReservations();
      //                if (this.endDate < this.startDate) {
      //                    this.endDate = this.startDate;
      this.storeDates();
      //                }
    },
    storeDates() {
      sessionStorage.setItem('startDate', this.startDate);
      sessionStorage.setItem('endDate', this.endDate);
    }
  },
  mounted() {
    this.storeDates();
    this.getVehicles();
    if(!document.cookie){
      this.$router.push({ name: 'Login' });
    }
  },
  created() {
    this.getReservations(false);
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
