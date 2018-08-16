import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import CookieMixin from '@/mixins/CookieMixin'
import DataMixin from '@/mixins/DataMixin'

Vue.use(VueAxios, axios);

export default {
  mixins: [CookieMixin, DataMixin],
  data() {
    return {
      vehicles: null,
      vehicle: null,
      terms: null,
      userdata: this.getCookie('userData'),
      termsLoaded: false,
      supplierVehicles: null,
    }
  },
  computed: {
    getGoogleMapSrc() {
      if (this.vehicle) {
        let apiKey = "AIzaSyB_e3fAT6awBlo7wAQq4pej5DHLSC6BUyA";
        let formatedLocation =
          this.vehicle.field_straat[0].value + "+" +
          this.vehicle.field_nummer[0].value + "+" +
          this.vehicle.field_postcode[0].value + "+" +
          this.vehicle.field_gemeente.value
        return "https://www.google.com/maps/embed/v1/place?key=" + apiKey + "&q=" + formatedLocation;
      }
    },
    getVehicleName() {
      if (this.vehicle) {
        return this.vehicle.field_merk.value + " " + this.vehicle.name[0].value;
      }
    },
  },
  methods: {
    getVehicles() {
      axios.get('http://drupal.dd:8083/api/v1/vehicles?_format=json')
        .then(response => {
          this.vehicles = response.data;
          console.log(this.vehicles);
        })
        .catch(e => {
          console.log(e);
        })
    },

    getSupplierVehicles(supplierId, dataObject) {
      axios.get('http://drupal.dd:8083/api/v1/supplier/' + supplierId + '/vehicles?_format=json')
        .then(response => {
          this.supplierVehicles = response.data;
          console.log(this.supplierVehicles);
        })
        .catch(e => {
          console.log(e);
        })
    },
    getVehicle(id) {
      axios.get('http://drupal.dd:8083/wheel/vehicle/' + id + '?_format=json', {
          headers: {
            'Content-Type': 'application/hal+json',
            'X-CSRF-Token': this.userdata.user.csrf_token,
            'Authorization': 'Basic ' + this.userdata.auth,
          }
        })
        .then(response => {
          this.vehicle = response.data;
          this.getTermData('field_merk', this.vehicle);
          this.getTermData('field_type', this.vehicle);
          this.getTermData('field_gemeente', this.vehicle);
          this.getsupplierInfo(this.vehicle.field_supplier[0].target_id, "field_supplier", false, this.vehicle);
          this.getsupplierInfo(this.vehicle.field_supplier[0].target_id, "field_supplier", false, this.vehicle);
          this.termsLoaded = true;
          console.log(this.vehicle);
        }).catch(e => {
          console.log(e)
        })
    },
    getVehicleData(vehicleId) {
      axios.get('http://drupal.dd:8083/api/v1/terms?_format=json', {
          headers: {
            'Content-Type': 'application/hal+json',
            'X-CSRF-Token': this.userdata.user.csrf_token,
          }
        })
        .then(response => {
          this.terms = response.data;
          this.getVehicle(vehicleId);
          console.log(response);
        })
        .catch(e => {
          console.log(e)
        })
    },
  },
  mounted() {}
}
