<template>
    <div class="Vehicle">
        <div class="header" :style='{background: "url(" + vehicle.field_image_url[0].value+ ")" }'>
            <div class="overlay">
                <static-header :title='getVehicleName'></static-header>

                <div class="dynamic">
                    <div class="user">
                        <div class="image"></div>
                        <div class="name">
                            {{vehicle.field_supplier.name[0].value}}
                        </div>
                        <div class="score">
                            {{vehicle.field_supplier.field_score[0].value}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <ul class="informationList">
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
            <h3>Location</h3>
            <div class="location">
                <ul class="informationList">
                    <li class="informationItem">
                        <div class="left">
                            Straat
                        </div>
                        <div class="right">
                            {{vehicle.field_straat[0].value}} {{vehicle.field_nummer[0].value}}
                        </div>
                    </li>
                    <li class="informationItem">
                        <div class="left">
                            Postcode
                        </div>
                        <div class="right">
                            {{vehicle.field_postcode[0].value}}
                        </div>
                    </li>
                    <li class="informationItem">
                        <div class="left">
                            Gemeente
                        </div>
                        <div class="right">
                            {{vehicle.field_gemeente.value}}
                        </div>
                    </li>
                </ul>

            </div>
            <router-link  :to="{ name: 'VehicleEdit', params: { vehicleId: vehicle.id[0].value, supplierId: vehicle.field_supplier.id[0].value  }}">
                <button type="button" class="mainButton">Wijzigen</button>
            </router-link>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import axios from 'axios'
    import VueAxios from 'vue-axios'
    import StaticHeader from "../partials/StaticHeader.vue"

    export default {
        name: 'Vehicle',
        components: {
            'static-header': StaticHeader,
        },
        data() {
            return {
                vehicle: {
                    model: "placeholder",
                    merk: "placeholder",
                    type: "placeholder",
                    prijs: "placeholder",
                    bouwjaar: "placeholder",
                    kilometerstand: "placeholder",
                },
                location: {
                    straat: "placeholder",
                    nummer: "placeholder",
                    postcode: "placeholder",
                    gemeente: "placeholder",
                },
                image_url: "placeholder",
                supplier: {
                    id: "placeholder",
                    name: "placeholder"
                },
                cookie: null,
                config: null,
                taxonomiesLoaded: false,
                id: null,
            }
        },
        computed: {
            getGoogleMapSrc: function () {
                let self = this;
                if (self.taxonomiesLoaded) {
                    let apiKey = "AIzaSyB_e3fAT6awBlo7wAQq4pej5DHLSC6BUyA";
                    let formatedLocation =
                        this.vehicle.field_straat[0].value + "+" +
                        this.vehicle.field_nummer[0].value + "+" +
                        this.vehicle.field_postcode[0].value + "+" +
                        this.vehicle.field_gemeente.value
                    return "https://www.google.com/maps/embed/v1/place?key=" + apiKey + "&q=" + formatedLocation;
                }
            },
            getVehicleName: function () {
                let self = this;
                if (self.taxonomiesLoaded) {
                    return self.vehicle.field_merk.value + " " + self.vehicle.name[0].value;
                }
            },

        },
        methods: {
            getData() {
                let self = this;
                axios.get('http://drupal.dd:8083/wheel/vehicle/' + self.$route.params.vehicleId + '?_format=json', self.config)
                    .then(response => {
                        self.vehicle = response.data;
                        self.getTaxonomyTerm(self.vehicle.field_merk[0].target_id, "field_merk", false);
                        self.getsupplierInfo(self.vehicle.field_supplier[0].target_id, "field_supplier", false);
                        self.getTaxonomyTerm(self.vehicle.field_type[0].target_id, "field_type", false);
                        self.getTaxonomyTerm(self.vehicle.field_gemeente[0].target_id, "field_gemeente", true);
                        self.getUserNameFromId(self.vehicle.user_id[0].target_id, "user_id", false);


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
            getUserNameFromId(id, parentObject, loaded) {
                let self = this;
                axios.get('http://drupal.dd:8083/user/' + id + '?_format=json', self.config)
                    .then(response => {
                        self.vehicle[parentObject] = response.data;
                    })
                    .catch(e => {
                        console.log(e)
                    })
            },
            getsupplierInfo(id, parentObject, loaded) {
                let self = this;
                axios.get('http://drupal.dd:8083/wheel/supplier/' + id + '?_format=json', self.config)
                    .then(response => {
                        self.vehicle[parentObject] = response.data
                    })
                    .catch(e => {
                        this.errors.push(e)
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
        },

        created: function () {
            this.id = this.$route.params.vehicleId;
            this.getCookie('userData');
            this.getData();

        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
