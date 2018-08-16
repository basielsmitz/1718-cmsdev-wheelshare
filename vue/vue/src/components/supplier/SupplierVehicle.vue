<template>
<div class="Vehicle">
  <div v-if="vehicle" class="header" :style='{background: "url(" + vehicle.field_image_url[0].value+ ")" }'>
    <div class="overlay">
      <static-header :title='getVehicleName'></static-header>

      <div class="dynamic">
        <div class="provider">
          <div class="left">
            <p>Aanbieder</p>
          </div>
          <div class="right">
            <router-link :to="{ name: 'Supplier', params: { supplierId: vehicle.field_supplier.id }}">
              {{vehicle.field_supplier.value}}
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <ul class="informationList" v-if="vehicle">
      <li class="informationItem">
        <div class="left">
          Model
        </div>
        <div class="right">
          {{vehicle.name[0].value}}
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Merk
        </div>
        <div class="right">
          {{vehicle.field_merk.value}}
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Type
        </div>
        <div class="right">
          {{vehicle.field_type.value}}
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Prijs
        </div>
        <div class="right">
          € {{vehicle.field_price[0].value}}
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Bouwjaar
        </div>
        <div class="right">
          {{vehicle.field_bouwjaar[0].value}}
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          kilometerstand
        </div>
        <div class="right">
          {{vehicle.field_kilometerstand[0].value}} km
        </div>
      </li>
    </ul>
    <div class="location" v-if="vehicle">
      <div class="map">
        <iframe width="100%" height="150" frameborder="0" style="border:0" :src="getGoogleMapSrc" allowfullscreen>
                  </iframe>
      </div>
      <div class="address">
        <p>{{vehicle.field_straat[0].value}} {{vehicle.field_nummer[0].value}}</p>
        <p>{{vehicle.field_postcode[0].value}} {{vehicle.field_gemeente.value}}</p>
      </div>
    </div>
    <router-link :to="{ name: 'VehicleEdit', params: { vehicleId: vehicleId, vehicle: vehicle, supplierId: supplierId }}"><button class="mainButton" type="button">bewerk</button>
    </router-link>
  </div>
</div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import StaticHeader from "../partials/StaticHeader.vue"
import VehicleMixin from '@/mixins/VehicleMixin'

export default {
  name: 'SupplierVehicle',
  mixins: [VehicleMixin],
  components: {
    'static-header': StaticHeader,
  },
  data() {
    return {
      vehicleId: this.$route.params.vehicleId,
      supplierId: this.$route.params.supplierId,
    }
  },
  mounted() {
    this.getVehicleData(this.vehicleId);
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
