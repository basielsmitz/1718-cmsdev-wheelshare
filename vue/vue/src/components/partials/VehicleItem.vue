<template>
<div class="vehicleItem">
  <router-link :to="{ name: 'Vehicle', params: { vehicleId: id }}">
    <div class="vehicleContainer" v-bind:style='{ background: "url(" + imageUrl+ ")" }'>
      <div class="itemOverlay">
        <div class="top">
          <span class="left">{{location}}</span>
          <span class="right">{{type}}</span>
        </div>
        <div class="bottom">
          <h2>{{brand}} {{model}}</h2>
        </div>
      </div>
    </div>
  </router-link>
</div>
</template>

<script>
export default {
  name: 'VehicleItem',
  props: ['id', 'imageUrl', 'location', 'type', 'model', 'brand'],
  data() {
    return {

    }
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
