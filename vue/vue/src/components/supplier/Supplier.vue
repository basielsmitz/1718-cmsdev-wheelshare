<template>
<div class="Supplier">
  <div class="header">
    <static-header :title="pageTitle"></static-header>
    <div v-if="user && supplier" class="dynamic">
      <div class="user">
        <div class="image"></div>
        <div class="name">
          {{user.field_voornaam[0].value}} {{user.field_naam[0].value}}
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <ul v-if="user && supplier" class="informationList">
      <li class="informationItem">
        <div class="left">
          Naam
        </div>
        <div class="right">
          {{user.field_voornaam[0].value}} {{user.field_naam[0].value}}
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

    </ul>
    <h3>Momenteel beschikbare voertuigen</h3>
    <span  v-if="supplierUserMatch">
       <router-link :to="{ name: 'NewVehicle', params: {supplierId: supplierId, supplier: supplier, user: user}}"><button type="button" class="secondaryButton">Nieuw</button> </router-link>
    </span>
    <div v-if="supplierVehicles && supplier && userdata" class="container">
      <div v-if="supplierUserMatch" class="listOfVehicles">
        <vehicle-item-supplier v-for="vehicle in supplierVehicles.slice(0,3)" :key="vehicle.id" :id="vehicle.id" :model="vehicle.name" :imageUrl="vehicle.field_image_url" :type="vehicle.field_type" :brand="vehicle.field_merk" :supplierId="supplier.id[0].value"
          :location="vehicle.field_gemeente">
        </vehicle-item-supplier>
      </div>
      <div v-else class="listOfVehicles">
        <vehicle-item v-for="vehicle in supplierVehicles.slice(0,3)" :key="vehicle.id" :id="vehicle.id" :model="vehicle.name" :imageUrl="vehicle.field_image_url" :type="vehicle.field_type" :brand="vehicle.field_merk" :location="vehicle.field_gemeente">
        </vehicle-item>
      </div>
    </div>
    <router-link :to="{ name: 'SupplierOverview', params: {user: user, supplier: supplier, vehicles: supplierVehicles, supplierUserMatch: supplierUserMatch }}"><button type="button" class="mainButton">Meer</button> </router-link>
  </div>
</div>
</template>
<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import StaticHeader from '../partials/StaticHeader.vue'
import VechicleItemS from '../partials/VehicleItemS.vue'
import VechicleItem from '../partials/VehicleItem.vue'
import CookieMixin from '@/mixins/CookieMixin'
import VehicleMixin from '@/mixins/VehicleMixin'

export default {
  name: 'Supplier',
  mixins: [CookieMixin, VehicleMixin],
  components: {
    'static-header': StaticHeader,
    'vehicle-item': VechicleItem,
    'vehicle-item-supplier': VechicleItemS,
  },
  data() {
    return {
      pageTitle: 'Aanbieder',
      supplier: null,
      user: null,
      currentUser: null,
      userdata: this.getCookie('userData'),
      supplierUserMatch: false,
      supplierId: this.$route.params.supplierId,
    }
  },
  methods: {
    getData() {
      axios.get('http://drupal.dd:8083/wheel/supplier/' + this.supplierId + '?_format=json', {
          headers: {
            'Content-Type': 'application/hal+json',
            'X-CSRF-Token': this.userdata.user.csrf_token,
            'Authorization': 'Basic ' + this.userdata.auth,
          }
        })
        .then(response => {
          this.supplier = response.data;
          this.getSupplierVehicles(this.supplier.id[0].value, this.supplier);
          this.getUser(this.supplier.field_user[0].target_id, false);
        })
        .catch(e => {
          console.log(e)
        })
    },
    getUser(id, current) {
      axios.get('http://drupal.dd:8083/user/' + id + '?_format=json', {
          headers: {
            'Content-Type': 'application/hal+json',
            'X-CSRF-Token': this.userdata.user.csrf_token,
            'Authorization': 'Basic ' + this.userdata.auth,
          }
        })
        .then(response => {
          this.user = response.data;
          this.supplierUserMatch = this.supplier.field_user[0].target_id == this.userdata.user.current_user.uid;
        })
        .catch(e => {
          this.errors.push(e)
        })
    },
    getNormalDate(date) {
      let array = date.split("T");
      array = array[0].split("-");
      return array[2] + "/" + array[1] + "/" + array[0]
    },
  },
  mounted() {
    this.getData();
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
