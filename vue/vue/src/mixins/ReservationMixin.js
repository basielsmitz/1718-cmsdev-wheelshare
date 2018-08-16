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
      reservations: null,
      userdata: this.getCookie('userData'),
      reservationsLoaded: false,
    }
  },
  methods: {
    getReservations(userreservations) {
      axios.get('http://drupal.dd:8083/api/v1/reservations?_format=json', {
          headers: {
            'Content-Type': 'application/hal+json',
            'X-CSRF-Token': this.userdata.user.csrf_token,
            'Authorization': 'Basic ' + this.userdata.auth,
          }
        })
        .then(response => {
          console.log(response);
          this.reservations = response.data;
          if (userreservations) {
            this.getUserData();
          }else {
            this.filterReservations();
          }
        })
        .catch(e => {
          console.log(e);
        })
    },
    getReservation(id) {
      console.log(this.reservations);
      const reservation = this.reservations.find(data => {
        return data.uuid === id
      });
      return reservation
    },
  },
  mounted() {}
}
