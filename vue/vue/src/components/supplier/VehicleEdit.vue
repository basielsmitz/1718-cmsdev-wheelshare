<template>
<div class="VehicleEdit">
  <div v-if="vehicle" class="header" :style='{background: "url(" + vehicle.field_image_url[0].value+ ")" }'>
    <div class="overlay">
      <static-header :title='pageTitle'></static-header>

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
          € <input type="number" name="price" id="price" v-model="vehicle.field_price[0].value" />
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
          <input type="number" name="kmStand" id="kmStand" v-model="vehicle.field_kilometerstand[0].value" /> km
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Straat
        </div>
        <div class="right">
          <input type="text" name="street" id="street" v-model="vehicle.field_straat[0].value" />
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Nummer
        </div>
        <div class="right">
          <input type="number" name="nummer" id="nummer" v-model="vehicle.field_nummer[0].value" />
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Postcode
        </div>
        <div class="right">
          <input type="number" name="postcode" id="postcode" v-model="vehicle.field_postcode[0].value" />
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Gemeente
        </div>
        <div class="right">
          <input type="text" name="city" id="city" v-model="vehicle.field_gemeente.value" />
        </div>
      </li>
    </ul>
    <button @click="update" type="button" class="mainButton">Bewerk</button>
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
  name: 'VehicleEdit',
  mixins: [VehicleMixin],
  components: {
    'static-header': StaticHeader,
  },
  data() {
    return {
      pageTitle: "Edit",
      vehicle: this.$route.params.vehicle,
      userdata: this.getCookie('userData'),
    }
  },
  methods: {
    update() {
      const data = {
        "data": {
          "type": "vehicle--vehicle",
          "id": this.vehicle.uuid[0].value,
          "attributes": {
            "field_price": this.vehicle.field_price[0].value,
            "field_straat": this.vehicle.field_straat[0].value,
            "field_nummer": this.vehicle.field_nummer[0].value,
            "field_postcode": this.vehicle.field_postcode[0].value,
            "field_kilometerstand": this.vehicle.field_kilometerstand[0].value,
          },
          "relationships": {
            "field_gemeente": {
              "data": {
                "type": "taxonomy_term--gemeente",
                "id": this.vehicle.field_gemeente.uuid
              },
            },
          }
        }
      };
      axios.patch('http://drupal.dd:8083/jsonapi/vehicle/vehicle/' + this.vehicle.uuid[0].value, data, {
          headers: {
            'Content-Type': 'application/vnd.api+json',
            'Accept': 'application/vnd.api+json',
            'X-CSRF-Token': this.userdata.user.csrf_token,
            'Authorization': 'Basic ' + this.userdata.auth,
          }
        })
        .then(response => {
          console.log(response);
          this.$router.push({ name: 'SupplierVehicle' , params: {supplierId: this.$route.params.supplierId, vehicleId: this.$route.params.this.$route.params.supplierId }});
        })
        .catch(e => {
          console.log(e);
        })
    },
  },
  mounted() {
    this.pageTitle = 'Bewerk ' + this.getVehicleName;
    if(!this.$route.params.vehicle){
      this.$router.push({ name: 'SupplierVehicle' , params: {supplierId: this.$route.params.supplierId, vehicleId: this.$route.params.this.$route.params.supplierId }});
    } else {
      this.getSelectData();
    }
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
