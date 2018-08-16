<template>
<div class="UserDetail">
  <div class="header">
    <static-header :title="pageTitle"></static-header>

    <div class="dynamic">
      <div class="user">
        <div class="image"></div>
        <div class="name">{{getFullname}}</div>
        <div v-if="user" class="extra">
          <router-link :to="{ name: 'Supplier', params: { supplierId: user.field_supplier.id }}">
            Aanbiedersprofiel
          </router-link>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <div v-if="user" class="userInfo">
      <ul class="informationList">
        <!-- <li class="informationItem">
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
                    </li> -->
        <li class="informationItem">
          <div class="left">
            E-mail
          </div>
          <div class="right">
            <input type="email" name="email" id="email" v-model="user.field_email[0].value" />
          </div>
        </li>
        <li class="informationItem">
          <div class="left">
            Gsmnummer
          </div>
          <div class="right">
            <input type="text" name="gsm_nummer" id="gsm_nummer" v-model="user.field_gsm_nummer[0].value" />
          </div>
        </li>
        <li class="informationItem">
          <div class="left">
            straat + nummer
          </div>
          <div class="right">
            <input type="text" name="straat" id="straat" v-model="user.field_straat[0].value" />
            <input type="text" name="nummer" id="nummer" v-model="user.field_nummer[0].value" />

          </div>
        </li>
        <li class="informationItem">
          <div class="left">
            Postcode
          </div>
          <div class="right">
            <input type="text" name="postcode" id="postcode" v-model="user.field_postcode[0].value" />
          </div>
        </li>
        <li class="informationItem">
          <div class="left">
            Gemeente
          </div>
          <div class="right">
            <input type="text" name="gemeente" id="gemeente" v-model="user.field_gemeente[0].value" />
          </div>
        </li>

      </ul>
    </div>
    <button @click="update" type="button" class="mainButton">Bewerk</button>
  </div>
</div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import StaticHeader from "../partials/StaticHeader.vue"
import CookieMixin from '@/mixins/CookieMixin'

export default {
  name: 'UserDetailEdit',
  mixins: [CookieMixin],
  components: {
    'static-header': StaticHeader,
  },
  data() {
    return {
      pageTitle: 'UserDetail',
      user: null,
      userdata: this.getCookie('userData'),
    }
  },
  computed: {
    getFullname() {
      if(this.user) {
        return this.user.field_voornaam[0].value + " " + this.user.field_naam[0].value;
      }
    }
  },
  methods: {
    update() {
      console.log('update');
      const data = {
        "data": {
          "type": "user--user",
          "id": this.user.uuid[0].value,
          "attributes": {
            "field_email": this.user.field_email[0].value,
            "field_gemeente": this.user.field_gemeente[0].value,
            "field_gsm_nummer": this.user.field_gsm_nummer[0].value,
            "field_nummer": this.user.field_nummer[0].value,
            "field_postcode": this.user.field_postcode[0].value,
            "field_straat": this.user.field_straat[0].value,
          }
        }
      }
      axios.patch('http://drupal.dd:8083/jsonapi/user/user/' + this.user.uuid[0].value, data, {
          headers: {
            'Content-Type': 'application/vnd.api+json',
            'Accept': 'application/vnd.api+json',
            'X-CSRF-Token': this.userdata.user.csrf_token,
            'Authorization': 'Basic ' + this.userdata.auth,
          }
        })
        .then(response => {
          console.log(response);
        })
        .catch(e => {
          console.log(e);
        })

    },
  },
  mounted() {
    if(!this.$route.params.user){
      this.$router.push({ name: 'User' });
    } else {
      this.user = this.$route.params.user;
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="sass">
    @import "../../assets/sass/specific/test2.scss"
</style>
