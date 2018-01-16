<template>
    <div class="Supplier">
        <div class="header">
            <static-header :title="pageTitle"></static-header>

            <div class="dynamic">
                <div class="user">
                    <div class="image"></div>
                    <div class="name">
                        {{user.field_voornaam[0].value}} {{user.field_naam[0].value}}
                    </div>
                    <div class="score">
                        {{supplier.field_score[0].value}}
                    </div>
                </div>

            </div>
        </div>
        <div class="content">
            <ul class="informationList">
                <li class="informationItem">
                    <div class="left">
                        Naam
                    </div>
                    <div class="right">
                        {{user.field_voornaam[0].value}} {{user.field_naam[0].value}}
                    </div>
                </li>
                <li class="informationItem">
                    <div class="left">
                        Geslacht
                    </div>
                    <div class="right">
                        {{user.field_gel[0].value}}
                    </div>
                </li>
                <li class="informationItem">
                    <div class="left">
                        Geboortedatum
                    </div>
                    <div class="right">
                        {{getNormalDate(user.field_geboortedatum[0].value)}}
                    </div>
                </li>
                <li class="informationItem">
                    <div class="left">
                        Locatie
                    </div>
                    <div class="right">
                        {{user.field_gemeente[0].value}}
                    </div>
                </li>
                <li class="informationItem">
                    <div class="left">
                        score
                    </div>
                    <div class="right">
                        {{supplier.field_score[0].value}}
                    </div>
                </li>

            </ul>
            <h3>Momenteel beschikbare voertuigen</h3>
            <div class="container">
                <div class="listOfVehicles">
                    <vehicle-item v-for="vehicle in supplier.field_vehicles"
                                  :key="vehicle.id[0].value"
                                  :id="vehicle.id[0].value"
                                  :model="vehicle.name[0].value"
                                  :imageUrl="vehicle.field_image_url[0].value"
                                  :type="vehicle.field_type.value"
                                  :brand="vehicle.field_merk.value"
                                  :location="vehicle.field_gemeente.value">
                    </vehicle-item>
                </div>
            </div>
            <router-link :to="{ name: 'SupplierOverview'}"><button type="button" class="mainButton" >Meer</button> </router-link>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import axios from 'axios'
    import VueAxios from 'vue-axios'
    import StaticHeader from "../partials/StaticHeader.vue"
    import VechicleItem from "../partials/VehicleItem.vue"

    export default {
        name: 'Supplier',
        components: {
            'static-header': StaticHeader,
            'vehicle-item': VechicleItem,
        },
        data() {
            return {
                pageTitle: 'Aanbieder',
                supplier: null,
                user: null,
            }
        },
        methods: {
            getData() {
                let self = this;
                axios.get('http://drupal.dd:8083/wheel/supplier/' + self.$route.params.supplierId + '?_format=json', self.config)
                    .then(response => {
                        self.supplier = response.data;

                        self.getUser(self.supplier.field_user[0].target_id, "field_user", false);

                        let index = 0;
                        self.supplier.field_vehicles.forEach(function (element) {
                            if (index === 3) {
                                return false;
                            } else {
                                if (index === 0) {
                                    self.getVehicle(element.target_id, "field_vehicles", true, index)
                                } else {
                                    self.getVehicle(element.target_id, "field_vehicles", false, index)
                                }
                                index++;
                            }
                        });
                    })
                    .catch(e => {
                        console.log(e)
                    })
            },
            getUser(id, parentObject, loaded) {
                let self = this;
                axios.get('http://drupal.dd:8083/user/' + id + '?_format=json', self.config)
                    .then(response => {
                        self.user = response.data;
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            getNormalDate(date) {
                let array = date.split("T");
                array = array[0].split("-");
                return array[2] + "/" + array[1] + "/" + array[0]
            },
            getVehicle(id, parentObject, first, index) {
                let self = this;
                if (first) {
                    self.supplier[parentObject] = [];
                }
                axios.get('http://drupal.dd:8083/wheel/vehicle/' + id + '?_format=json', self.config)
                    .then(response => {
                        self.supplier[parentObject].push(response.data);
                        let ind = 0;
                        self.supplier[parentObject].forEach(function (element) {
                            self.getTaxonomyTerm(element.field_merk[0].target_id, ind, 'field_merk');
                            self.getTaxonomyTerm(element.field_type[0].target_id, ind, 'field_type');
                            self.getTaxonomyTerm(element.field_gemeente[0].target_id, ind, 'field_gemeente');
                            ind++;
                        });
                    })
                    .catch(e => {
                        console.log(e)
                    })
            },
            getTaxonomyTerm(id, index, parentObject) {
                let self = this;
                axios.get('http://drupal.dd:8083/taxonomy/term/' + id + '?_format=json', self.config)
                    .then(response => {
                        self.supplier.field_vehicles[index][parentObject] = {
                            value: response.data.name[0].value,
                            id: id,
                        }
                    })
                    .catch(e => {
                        console.log(e)
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
            }
            ,
        },
        mounted() {
            this.getCookie('userData');
            this.getData();

        }

    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
