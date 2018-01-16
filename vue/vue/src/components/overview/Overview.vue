<template>
    <div class="Overview">
        <div class="header">
            <static-header :title="pageTitle"></static-header>
            <div class="dynamic">
                <form class="filters">
                    <div class="row">
                        <div class="inputGroup left" >
                            <label>Van</label>
                            <input @change="changeStart" :min="startDate" v-model="startDate" type="date"
                                   title="startDate"
                                   id="startDate"/>
                        </div>
                        <div class="inputGroup right">
                            <label>Tot</label>
                            <input @change="changeEnd" :min="startDate" v-model="endDate" type="date" title="endDate"
                                   id="endDate"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="left">
                            <select title="location" id="location">
                                <option value="Gent">Gent</option>
                                <option value="Brugge">Brugge</option>
                            </select>
                            <select title="type" id="type">
                                <option value="Wagen">Wagen</option>
                                <option value="Motor">Motor</option>
                                <option value="Scooter">Scooter</option>
                            </select>

                        </div>
                        <div class="right">
                            <input type="search" name="search" placeholder="Zoek" id="search">
                        </div>


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
                                  :model="vehicle.name"
                                  :imageUrl="vehicle.field_image_url"
                                  :type="vehicle.field_type"
                                  :brand="vehicle.field_merk"
                                  :location="vehicle.field_gemeente">
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

    let moment = require('moment');
    import VueLocalStorage from 'vue-localstorage'

    Vue.use(VueLocalStorage)

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
                vehicles: null,
                startDate: moment().format("YYYY-MM-DD"),
                endDate: moment().add(1, 'days').format("YYYY-MM-DD"),
            }
        },
        methods: {
            getVehicles() {
                self = this

                axios.get('http://drupal.dd:8083/api/v1/vehicles?_format=json')
                    .then(response => {
                        self.vehicles = response.data;
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            getCookie(cname) {
                let name = cname + "=";
                let decodedCookie = decodeURIComponent(document.cookie);
                let ca = decodedCookie.split(';');
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) === ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) === 0) {
                        return c.substring(name.length, c.length);
                    }
                }
                return "";
            },
            changeStart() {
                let now = new moment().format("YYYY-MM-DD");
                if (this.startDate < now) {
                    this.startDate = now;
                    this.storeDates();
                }
            },
            changeEnd() {
                if (this.endDate < this.startDate) {
                    this.endDate = this.startDate;
                    this.storeDates();
                }
            },
            storeDates() {
                sessionStorage.setItem('startDate', this.startDate);
                sessionStorage.setItem('endDate', this.endDate);
            }


        },
        mounted() {
            this.getVehicles();
            this.storeDates();
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
