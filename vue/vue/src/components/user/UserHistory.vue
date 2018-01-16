<template>
    <div class="UserHistory">
        <div class="header">
            <static-header :title="pageTitle"></static-header>

            <div class="dynamic">
                <div class="user">
                    <div class="image"></div>
                    <div class="name">Fons De Spons</div>
                    <div class="extra">
                        <router-link :to="{ name: 'Supplier', params: { supplierId: user.field_supplier.id }}">
                            Aanbiedersprofiel
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="reservations">
                <ul class="informationList">
                    <li class="informationItem" v-for="reservation in user.field_reservations">
                        <div class="left">
                            {{ reservation.name[0].value }}

                        </div>
                        <div class="right">
                            {{ getNormalDate(reservation.field_startdate[0].value)
                            }} -  {{ getNormalDate(reservation.field_enddate[0].value) }}
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import axios from 'axios'
    import VueAxios from 'vue-axios'
    import StaticHeader from "../partials/StaticHeader.vue"

    export default {
        name: 'UserHistory',
        components: {
            'static-header': StaticHeader,
        },
        data() {
            return {

                pageTitle: 'Gebruiker',
                user: null,


            }
        },
        methods: {
            getData() {
                let userData = this.getCookie('userData');
                let self = this;
                axios.get('http://drupal.dd:8083//user/' + userData.user.current_user.uid + '?_format=json', self.config)
                    .then(response => {
                        self.user = response.data;
                        self.getsupplierInfo(self.user.field_supplier[0].target_id, "field_supplier", false);
//                        self.getTaxonomyTerm(self.vehicle.field_gemeente[0].target_id, "field_gemeente", true);
                        let index = 0;
                        self.user.field_reservations.forEach(function (element) {

                            if (index === 0) {
                                self.getReservations(element.target_id, "field_reservations", true)
                            } else {
                                self.getReservations(element.target_id, "field_reservations", false)
                            }
                            index++;

                        });
                    })
                    .catch(e => {
                        console.log(e)
                    })
            },
            getTaxonomyTerm(id, parentObject, loaded) {
                let self = this;
                axios.get('http://drupal.dd:8083/taxonomy/term/' + id + '?_format=json', self.config)
                    .then(response => {
                        self.user[parentObject] = {
                            value: response.data.name[0].value,
                            id: id,
                        }

                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            getReservations(id, parentObject, first) {
                let self = this;
                if (first) {
                    self.user[parentObject] = [];
                }
                axios.get('http://drupal.dd:8083/wheel/reservation/' + id + '?_format=json', self.config)
                    .then(response => {
                        self.user[parentObject].push(response.data);

                    })
                    .catch(e => {
                        console.log(e)
                    })
            },

            getsupplierInfo(id, parentObject, loaded) {
                let self = this;
                axios.get('http://drupal.dd:8083/wheel/supplier/' + id + '?_format=json', self.config)
                    .then(response => {
                        self.user[parentObject] = {
                            value: response.data.name[0].value,
                            id: id,
                        }
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
        mounted() {
            this.getData();
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
