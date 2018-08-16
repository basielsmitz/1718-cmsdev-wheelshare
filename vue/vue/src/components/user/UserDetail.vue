<template>
<div class="UserDetail">
  <div class="header">
    <static-header :title="pageTitle"></static-header>

    <div class="dynamic">
      <div v-if="user" class="user">
        <div class="image"></div>
        <div class="name">{{getFullname}}</div>
        <div class="extra">
          <router-link :to="{ name: 'Supplier', params: { supplierId: user.field_supplier.id }}">
            Aanbiedersprofiel
          </router-link>
        </div>
      </div>
    </div>
  </div>
  <div v-if="user" class="content">
    <div class="userInfo">
      <ul class="informationList">
        <li class="informationItem">
          <div class="left">
            Naam
          </div>
          <div class="right">
            {{user.field_naam[0].value}}
          </div>
        </li>
        <li class="informationItem">
          <div class="left">
            Voornaam
          </div>
          <div class="right">
            {{user.field_voornaam[0].value}}
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
            E-mail
          </div>
          <div class="right">
            {{user.field_email[0].value}}
          </div>
        </li>
        <li class="informationItem">
          <div class="left">
            Gsmnummer
          </div>
          <div class="right">
            {{user.field_gsm_nummer[0].value}}
          </div>
        </li>
        <li class="informationItem">
          <div class="left">
            straat + nummer
          </div>
          <div class="right">
            {{user.field_straat[0].value}} {{user.field_nummer[0].value}}
          </div>
        </li>
        <li class="informationItem">
          <div class="left">
            Postcode
          </div>
          <div class="right">
            {{user.field_postcode[0].value}}
          </div>
        </li>
        <li class="informationItem">
          <div class="left">
            Gemeente
          </div>
          <div class="right">
            {{user.field_gemeente[0].value}}
          </div>
        </li>

      </ul>
    </div>
    <router-link :to="{ name: 'UserDetailEdit', params: {user: user} }"><button type="button" class="mainButton">Wijzig</button> </router-link>
  </div>

</div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import StaticHeader from "../partials/StaticHeader.vue"

export default {
  name: 'UserDetail',
  components: {
    'static-header': StaticHeader,
  },
  data() {
    return {
      pageTitle: 'UserDetail',
      user: null,
    }
  },
  computed: {
    getFullname() {
      return this.user.field_voornaam[0].value + " " + this.user.field_naam[0].value
    }
  },
  methods: {
    getNormalDate(date) {
      let array = date.split("T");
      array = array[0].split("-");
      return array[2] + "/" + array[1] + "/" + array[0]
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
