<template>
    <div class="UserDetail">
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
            <div class="userInfo">
                <ul class="informationList">
                    <li class="informationItem">
                        <div class="left">
                            Naam
                        </div>
                        <div class="right">
                            <input type="text" name="naam" id="naam" v-model="user.field_naam[0].value"/>
                        </div>
                    </li>
                    <li class="informationItem">
                        <div class="left">
                            Voornaam
                        </div>
                        <div class="right">
                            <input type="text" name="voornaam" id="voornaam" v-model="user.field_voornaam[0].value"/>
                        </div>
                    </li>
                    <li class="informationItem">
                        <div class="left">
                            Geslacht
                        </div>
                        <div class="right">
                            <input type="text" name="geslacht" id="geslacht" v-model="user.field_gel[0].value"/>
                        </div>
                    </li>
                    <li class="informationItem">
                        <div class="left">
                            Geboortedatum
                        </div>
                        <div class="right">
                            <input type="date" name="geboortedatum" id="geboortedatum" v-model="user.field_geboortedatum[0].value"/>
                        </div>
                    </li>
                    <li class="informationItem">
                        <div class="left">
                            E-mail
                        </div>
                        <div class="right">
                            <input type="email" name="email" id="email" v-model="user.field_email[0].value"/>
                        </div>
                    </li>
                    <li class="informationItem">
                        <div class="left">
                            Gsmnummer
                        </div>
                        <div class="right">
                            <input type="text" name="gsm_nummer" id="gsm_nummer" v-model="user.field_gsm_nummer[0].value"/>
                        </div>
                    </li>
                    <li class="informationItem">
                        <div class="left">
                            straat + nummer
                        </div>
                        <div class="right">
                            <input type="text" name="straat" id="straat" v-model="user.field_straat[0].value"/>
                            <input type="text" name="nummer" id="nummer" v-model="user.field_nummer[0].value"/>

                        </div>
                    </li>
                    <li class="informationItem">
                        <div class="left">
                            Postcode
                        </div>
                        <div class="right">
                            <input type="text" name="postcode" id="postcode" v-model="user.field_postcode[0].value"/>
                        </div>
                    </li>
                    <li class="informationItem">
                        <div class="left">
                            Gemeente
                        </div>
                        <div class="right">
                            <input type="text" name="gemeente" id="gemeente" v-model="user.field_gemeente[0].value"/>
                        </div>
                    </li>

                </ul>
            </div>
            <button type="button" class="mainButton">Bewerk</button>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import axios from 'axios'
    import VueAxios from 'vue-axios'
    import StaticHeader from "../partials/StaticHeader.vue"

    export default {
        name: 'UserDetailEdit',
        components: {
            'static-header': StaticHeader,
        },
        data() {
            return {
                pageTitle: 'UserDetail',
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
                        self.user.field_geboortedatum[0].value = self.getDataDate(self.user.field_geboortedatum[0].value);

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
            getDataDate(date){
                let array = date.split("T")
                return array[0]
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
<style scoped lang="sass">
    @import "../../assets/sass/specific/test2.scss"
</style>
