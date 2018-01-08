<template>
<div class="Overview">
  <div class="header">
    <static-header :title="pageTitle"></static-header>
    <div class="dynamic">
        <form class="filters">
            <div class="row">
                <div class="inputGroup">
                    <label>Van</label>
                    <input type="date" title="from" id="from"/>
                </div>
                <div class="inputGroup">
                    <label>Tot</label>
                    <input type="date" title="to" id="to"/>
                </div>
            </div>
            <div class="row">
                <select title="location" id="location">
                    <option value="Gent">Gent</option>
                    <option value="Brugge">Brugge</option>
                </select>
                <select title="type" id="type">
                    <option value="Gent">Gent</option>
                    <option value="Brugge">Brugge</option>
                </select>
                <input type="search" name="search" placeholder="Zoek" id="search">

            </div>
        </form>
    </div>
  </div>
  <div class="content">
    <div class="container">
      <div class="listOfVehicles">
        <vehicle-item v-for="vehicle in vehicles"
                      :key="vehicle.id"
                      :id="vehicle.id"
                      :model="vehicle.model"
                      :imageUrl="vehicle.imageUrl"
                      :type="vehicle.type"
                      :brand="vehicle.brand"
                      :location="vehicle.location">
        </vehicle-item>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import StaticHeader from "../partials/StaticHeader.vue"
import VehicleItem from "../partials/VehicleItem.vue"

export default {
  name: 'Overview',
  components: {
      VehicleItem,
      'static-header': StaticHeader,
  'vehicle-item': VehicleItem,
  },

  data() {
    return {
      pageTitle: 'Overzicht voertuigen',
      vehicles: [{
        id: 123,
        type: "Wagen",
        brand: "Citroën",
        model: "DS3",
        location: "Gent",
        imageUrl: " http://placecage.com/c/600/400"
      }, {
        id: 124,
        type: "Wagen",
        brand: "Peugeot",
        model: "208",
        location: "Gent",
        imageUrl: " http://placecage.com/c/600/400"
      }, {
        id: 125,
        type: "Wagen",
        brand: "Opel",
        model: "Corsa",
        location: "Gent",
        imageUrl: " http://placecage.com/c/600/400"
      }, ]
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
