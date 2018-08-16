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
    <div class="container">
      <div v-if="vehicles" class="listOfVehicles">
        <vehicle-item v-for="vehicle in vehicles" :key="vehicle.id" :id="vehicle.id" :model="vehicle.name" :imageUrl="vehicle.field_image_url" :type="vehicle.field_type" :brand="vehicle.field_merk" :location="vehicle.field_gemeente">
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
import VechicleItemS from "../partials/VehicleItemS.vue"
import VechicleItem from "../partials/VehicleItem.vue"

export default {
  name: 'SupplierOverview',
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
      vehicles: null,
    }
  },
  methods: {
  },
  mounted() {
    if(!this.$route.params.user || !this.$route.params.supplier || !this.$route.params.vehicles){
      this.$router.push({ name: 'Supplier' , params: {supplierId: this.$route.params.supplierId}});
    } else {
      this.user = this.$route.params.user;
      this.supplier = this.$route.params.supplier;
      this.vehicles = this.$route.params.vehicles    }
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
