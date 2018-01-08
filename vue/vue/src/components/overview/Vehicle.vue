<template>
    <div class="Vehicle">
        <div class="header" :style='{background: "url(" + vehicle.imageUrl+ ")" }'>
            <div class="overlay">
                <static-header :title='getVehicleName'></static-header>

                <div class="dynamic">
                    <div class="provider">
                        <div class="left">
                            <p>Aanbieder</p>
                        </div>
                        <div class="right">
                            <router-link :to="{ name: 'Supplier', params: { supplierId: vehicle.supplierId }}">Fons De Spons</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <ul class="informationList">
                <li class="informationItem" v-for="(value, key) in vehicle">
                    <div class="left">
                        {{ key }}
                    </div>
                    <div class="right">
                        {{ value }}
                    </div>
                </li>
            </ul>
            <div class="location">
                <div class="map">
                    <iframe
                            width="100%"
                            height="250"
                            frameborder="0" style="border:0"
                            :src="getGoogleMapSrc" allowfullscreen>
                    </iframe>
                </div>
                <div class="address">
                    <p>{{vehicle.street}} {{vehicle.number}}</p>
                    <p>{{vehicle.postal}} {{vehicle.city}}</p>
                </div>
            </div>
            <router-link class="mainButton" :to="{ name: 'Reservation', params: { vehicleId: vehicle.id }}">reserveer</router-link>
        </div>
    </div>
</template>

<script>
    import StaticHeader from "../partials/StaticHeader.vue"

    export default {
        name: 'Vehicle',
        components: {
            'static-header': StaticHeader,
        },
        data() {
            return {
                vehicle: {
                    id: 123,
                    type: "Wagen",
                    brand: "Citroën",
                    model: "DS3",
                    city: "Gent",
                    street: "Molenaarsstraat",
                    number: "53",
                    postal: "9000",
                    imageUrl: " http://placecage.com/c/600/400",
                    supplier: 'Fons De Spons',
                    fuelType: 'Diesel',
                    supplierId: 128
                },

            }
        },
        computed: {
            getGoogleMapSrc: function () {
               let apiKey = "AIzaSyB_e3fAT6awBlo7wAQq4pej5DHLSC6BUyA";
               let formatedLocation = this.vehicle.street +"+"+this.vehicle.number+"+"+this.vehicle.postal+"+"+this.vehicle.city
                console.log(formatedLocation);
                return"https://www.google.com/maps/embed/v1/place?key="+apiKey+"&q="+formatedLocation;
            },
            getVehicleName: function () {
                console.log(this.vehicle.brand);
                return this.vehicle.brand + " " + this.vehicle.model;
            }

        },

        mounted: function () {
            console.log(this.$route.params)
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
