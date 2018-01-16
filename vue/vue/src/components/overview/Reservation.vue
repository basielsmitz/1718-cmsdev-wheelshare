<template>
    <div class="Reservation">
        <div class="header" :style='{background: "url(" + vehicle.field_image_url[0].value+ ")" }'>
            <div class="overlay">
                <static-header :title='getVehicleName'></static-header>

                <div class="dynamic">
                    <div class="provider">
                        <div class="left">
                            <p>Aanbieder</p>
                        </div>
                        <div class="right">
                            <router-link :to="{ name: 'Supplier', params: { supplierId: vehicle.id[0].value }}">
                                {{vehicle.field_supplier.value}}
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
                        <span>{{getNormalDate(startDate)}}</span>
                    </div>
                </li>
                <li class="informationItem">
                    <div class="left">
                        <span>Tot</span>
                    </div>
                    <div class="right">
                        <span>{{getNormalDate(endDate)}}</span>
                    </div>
                </li>
                <li class="InputItem informationItem">
                    <div class="left">
                        <span title="pickup">Ophalen:</span> <input title="pickup" id="pickup" v-model="startTime"
                                                                    type="time">
                    </div>
                    <div class="right">
                        <span title="dropoff">Afzetten:</span> <input title="dropoff" id="dropoff" v-model="endTime"
                                                                      type="time">
                    </div>
                </li>
                <li class="informationItem">
                    <div class="left">
                        <span>Aanbieder</span>
                    </div>
                    <div class="right">
                        <span><router-link :to="{ name: 'Supplier', params: { supplierId: vehicle.field_supplier.id }}">{{vehicle.field_supplier.value}}</router-link></span>
                    </div>
                </li>
            </ul>
            <div class="location">
                <h3>Ophaaal en afzet locatie</h3>
                <div class="map">
                    <iframe
                            width="100%"
                            height="200"
                            frameborder="0" style="border:0"
                            :src="getGoogleMapSrc" allowfullscreen>
                    </iframe>
                </div>
                <div class="address">
                    <p>{{vehicle.street}} {{vehicle.number}}</p>
                    <p>{{vehicle.postal}} {{vehicle.city}}</p>
                </div>
            </div>
            <button type="button" class="mainButton" @click="confirmReservation">Bevestig</button>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import axios from 'axios'
    import VueAxios from 'vue-axios'
    import StaticHeader from "../partials/StaticHeader.vue"

    export default {
        name: 'Reservation',
        components: {
            'static-header': StaticHeader,
        },
        data() {
            return {
                vehicle: null,
                startDate: null,
                endDate: null,
                startTime: "12:00",
                endTime: "12:00",
                config: null,
                taxonomiesLoaded: false,

            }
        },
        computed: {
            getGoogleMapSrc() {
                if (this.taxonomiesLoaded) {
                    let apiKey = "AIzaSyB_e3fAT6awBlo7wAQq4pej5DHLSC6BUyA";
                    let formatedLocation =
                        this.vehicle.field_straat[0].value + "+" +
                        this.vehicle.field_nummer[0].value + "+" +
                        this.vehicle.field_postcode[0].value + "+" +
                        this.vehicle.field_gemeente.value
                    console.log(formatedLocation);
                    return "https://www.google.com/maps/embed/v1/place?key=" + apiKey + "&q=" + formatedLocation;
                }
            },
            getVehicleName() {
                console.log(this.vehicle.field_merk);
                let self = this;
                if (self.taxonomiesLoaded) {
                    return self.vehicle.field_merk.value + " " + self.vehicle.name[0].value;
                }
            },
        },

        methods: {
            getNormalDate(date) {
                console.log(date);
                let array = date.split("-");
                return array[2] + "/" + array[1] + "/" + array[0]
            },
            confirmReservation: function () {
                console.log(this.config);
                let data =
                    {
                        "name": [
                            {
                                "value": "test"
                            }
                        ],
                        "field_enddate": [
                            {
                                "value": "2018-01-16T19:52:00"
                            }
                        ],
                        "field_startdate": [
                            {
                                "value": "2018-01-15T19:52:28"
                            }
                        ],
                        "field_supplier": [
                            {
                                "target_id": 1,
                            }
                        ],
                        "field_vehicle": [
                            {
                                "target_id": 1,
                            }
                        ]
                    }

                axios.post('http://drupal.dd:8083/entity/reservation?_format=hal_json', data, self.config)
                    .then(response => {
                        console.log(response);
                    })
                    .catch(e => {
                        console.log(e);
                    })


            },
            getCookie(cname) {
                let self = this;
                let name = cname + "=";
                let decodedCookie = decodeURIComponent(document.cookie);
                let ca = decodedCookie.split(';');
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) === ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) === 0) {
                        let result = JSON.parse(c.substring(name.length, c.length));

                        self.config = {
                            headers: {
                                'Content-Type': 'application/hal+json',
                                'X-CSRF-Token': result.user.csrf_token,
                                'Authorization': 'Basic ' + result.auth,
                            },
                        }
                        return result;
                    }
                }
                return "";
            },
            getData() {
                console.log(this.config);
                let self = this;
                axios.get('http://drupal.dd:8083/wheel/vehicle/' + self.$route.params.vehicleId + '?_format=json', self.config)
                    .then(response => {
                        self.vehicle = response.data;
                        self.getTaxonomyTerm(self.vehicle.field_merk[0].target_id, "field_merk", false);
                        self.getsupplierInfo(self.vehicle.field_supplier[0].target_id, "field_supplier", false);
                        self.getTaxonomyTerm(self.vehicle.field_gemeente[0].target_id, "field_gemeente", true);
                        console.log(self.vehicle)


                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            getTaxonomyTerm(id, parentObject, loaded) {
                let self = this;
                axios.get('http://drupal.dd:8083/taxonomy/term/' + id + '?_format=json', self.config)
                    .then(response => {
                        self.vehicle[parentObject] = {
                            value: response.data.name[0].value,
                            id: id,
                        }
                        if (loaded) {
                            self.taxonomiesLoaded = loaded;
                        }
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            getsupplierInfo(id, parentObject, loaded) {
                let self = this;
                axios.get('http://drupal.dd:8083/wheel/supplier/' + id + '?_format=json', self.config)
                    .then(response => {
                        self.vehicle[parentObject] = {
                            value: response.data.name[0].value,
                            id: id,
                        }
                        console.log(self.vehicle);
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            setDates() {
                this.startDate = sessionStorage.getItem('startDate');
                this.endDate = sessionStorage.getItem('endDate');
            },

        },
        mounted() {
            console.log(this.$route.params.vehicleId);
            this.getCookie('userData');
            this.getData()
            this.setDates();
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
