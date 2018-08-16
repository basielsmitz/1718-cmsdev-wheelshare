<template>
<div class="NewVehicle">
  <div class="header">
    <static-header :title="pageTitle"></static-header>
    <div v-if="user && supplier" class="dynamic">
      <div class="user">
        <div class="image"></div>
        <div class="name">
          {{user.field_voornaam[0].value}} {{user.field_naam[0].value}}
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <ul class="informationList">
      <li class="informationItem">
        <div class="left">
          Merk
        </div>
        <div class="right">
          <select v-if="types" v-model="vehicle.type">
            <option v-for="type, index in types" :value="type.uuid[0].value">{{type.name[0].value}}</option>
          </select>
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Merk
        </div>
        <div class="right">
          <select v-if="brands" v-model="vehicle.merk">
            <option v-for="merk, index in brands" :value="merk.uuid[0].value">{{merk.name[0].value}}</option>
          </select>
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Type
        </div>
        <div class="right">
          <input type="text" name="name" id="name" v-model="vehicle.name" />
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Bouwjaar
        </div>
        <div class="right">
          <input type="number" name="bouwjaar" id="bouwjaar" v-model="vehicle.bouwjaar" />
        </div>
      </li>

      <!-- <li class="informationItem">
        <div class="left">
          Naam
        </div>
        <div class="right">
          <input type="text" name="name" id="name" v-model="vehicle.name" />
        </div>
      </li> -->

      <li class="informationItem">
        <div class="left">
          Kilometerstand
        </div>
        <div class="right">
          <input type="number" name="kilometerstand" id="kilometerstand" v-model="vehicle.kilometerstand" />
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Prijs
        </div>
        <div class="right">
          <input type="number" name="price" id="price" v-model="vehicle.price" />
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Straat
        </div>
        <div class="right">
          <input type="text" name="straat" id="straat" v-model="vehicle.straat" />
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Nummer
        </div>
        <div class="right">
          <input type="text" name="nummer" id="nummer" v-model="vehicle.nummer" />
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Postcode
        </div>
        <div class="right">
          <input type="text" name="postcode" id="postcode" v-model="vehicle.postcode" />
        </div>
      </li>
      <li class="informationItem">
        <div class="left">
          Gemeente
        </div>
        <div class="right">
          <select v-if="gemeentes" v-model="vehicle.gemeente">
            <option v-for="gemeente, index in gemeentes" :value="gemeente.uuid[0].value">{{gemeente.name[0].value}}</option>
          </select>
        </div>
      </li>
    </ul>
    <!-- <router-link :to="{ name: 'SupplierOverview', params: {user: user, supplier: supplier, vehicles: supplierVehicles, supplierUserMatch: supplierUserMatch }}"><button type="button" class="mainButton">Meer</button> </router-link> -->
  </div>
</div>
</template>

<script>
import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import StaticHeader from "../partials/StaticHeader.vue"

export default {
  name: 'NewVehicle',
  components: {
    'static-header': StaticHeader,
  },
  data() {
    return {
      pageTitle: 'NewVehicle',
      supplier: this.$route.params.supplier,
      user: this.$route.params.user,
      vehicle: {
        name: null,
        bouwjaar: null,
        imageurl: null,
        kilometerstand: null,
        nummer: null,
        postcode: null,
        price: null,
        straat: null,
        gemeente: "2cfdda76-b8bc-4f8d-8f17-db9c5b32f57e",
        merk: "3db643c0-56bc-4d48-b9d4-ebacc37b80c4",
        type: "63cf3482-d72b-4243-8446-4d9c85d1ad0d",
      },
      terms: null,
      brands: null,
      gemeentes: null,
      types: null,
    }
  },
  methods: {
    postVehicle() {
      let data = {
        "data": {
          "type": "vehicle--vehicle",
          "attributes": {
            "name": vehicle.name,
            "field_bouwjaar": vehicle.bouwjaar,
            "field_image_url": vehicle.imageUrl,
            "field_kilometerstand": vehicle.kilometerstand,
            "field_nummer": vehicle.number,
            "field_postcode": vehicle.postcode,
            "field_price": vehicle.price,
            "field_straat": vehicle.straat,
          },
          "relationships": {
            "field_gemeente": {
              "data": {
                "type": "taxonomy_term--gemeente",
                "id": vehicle.gemeente
              },
            },
            "field_merk": {
              "data": {
                "type": "taxonomy_term--brands",
                "id":vehicle.merk,
              },
            },
            "field_supplier": {
              "data": {
                "type": "supplier--supplier",
                "id": this.supplier.uuid[0].value,
              },
            },
            "field_type": {
              "data": {
                "type": "taxonomy_term--type",
                "id": vehicle.type,
              },
            },
          },
        },
      }
    },
    getSelectData(){
        axios.get('http://drupal.dd:8083/api/v1/terms?_format=json')
          .then(response => {
            this.terms = response.data;
            this.brands = this.terms.filter(term => term.vid[0].target_id == "brands");
            this.types = this.terms.filter(term => term.vid[0].target_id == "type");
            this.gemeentes = this.terms.filter(term => term.vid[0].target_id == "gemeente");
          })
          .catch(e => {
          })
    },

  },
  mounted() {
    if(!this.$route.params.supplier){
      this.$router.push({ name: 'Supplier' , params: {supplierId: this.$route.params.supplierId}});
    } else {
      this.getSelectData();
    }
  },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>
