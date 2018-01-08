<template>
    <div class="Reservation">
        <div class="header" :style='{background: "url(" + vehicle.imageUrl+ ")" }'>
            <div class="overlay">
                <static-header :title='getVehicleName'></static-header>

                <div class="dynamic">
                    <div class="provider">
                        <div class="left">
                            <p>Aanbieder</p>
                        </div>
                        <div class="right">
                            <router-link :to="{ name: 'Supplier', params: { supplierId: vehicle.supplierId }}">
                                Fons De Spons
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
                    <div class="right">
                        <span>05/01/2018</span>
                    </div>
                </li>
                <li class="informationItem">
                    <div class="left">
                        <span>Van</span>
                    </div>
                    <div class="right">
                        <span>07/01/2018</span>
                    </div>
                </li>
                <li class="InputItem informationItem">
                    <div class="left">
                        <span title="pickup">Ophalen:</span> <input title="pickup" id="pickup" type="time">
                    </div>
                    <div class="right">
                        <span title="dropoff">Afzetten:</span> <input title="dropoff" id="dropoff" type="time">
                    </div>
                </li>
                <li class="informationItem">
                    <div class="left">
                        <span>Aanbieder</span>
                    </div>
                    <div class="right">
                        <span><router-link :to="{ name: 'Supplier', params: { supplierId: vehicle.supplierId }}">Fons De Spons</router-link></span>
                    </div>
                </li>
            </ul>
            <div class="location">
                <h3>Ophaaal en afzet locatie</h3>
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
            <button class="mainButton" :click="confirmReservation">Bevestig</button>
        </div>
    </div>
</template>

<script>
    import StaticHeader from "../partials/StaticHeader.vue"

    export default {
        name: 'Reservation',
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
                startDatum: new Date()
            }
        },
        computed: {
            getGoogleMapSrc: function () {
                let apiKey = "AIzaSyB_e3fAT6awBlo7wAQq4pej5DHLSC6BUyA";
                let formatedLocation = this.vehicle.street + "+" + this.vehicle.number + "+" + this.vehicle.postal + "+" + this.vehicle.city
                return "https://www.google.com/maps/embed/v1/place?key=" + apiKey + "&q=" + formatedLocation;
            },
            getVehicleName: function () {
                return this.vehicle.brand + " " + this.vehicle.model;
            }

        },
        methods: {
            confirmReservation: function () {
                console.log('confirming reservation")');
            }

        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
