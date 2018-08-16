import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import CookieMixin from '@/mixins/CookieMixin'

Vue.use(VueAxios, axios);

export default {
  mixins: [CookieMixin],
  data() {
    return {
      terms: null,
      userdata: this.getCookie('userData'),
      termsLoaded: false,
    }
  },
  methods: {
    getTermData(termName, dataobject) {
      const term = this.terms.find(term => {
        return term.uuid[0].value === dataobject[termName][0].target_uuid
      });
      dataobject[termName] = {
        value: term.name[0].value,
        uuid: term.uuid[0].value,
        id: term.tid[0].value,
      }
    },
    getTaxonomyTerm(id, parentObject, loaded, dataobject) {
      axios.get('http://drupal.dd:8083/taxonomy/term/' + id + '?_format=json', self.config)
        .then(response => {
          dataobject[parentObject] = {
            value: response.data.name[0].value,
            id: id,
          }
          if (loaded) {
            this.taxonomiesLoaded = loaded;
          }
        })
        .catch(e => {
          this.errors.push(e)
        })
    },
    getUserNameFromId(id, parentObject, loaded, dataobject) {
      axios.get('http://drupal.dd:8083/user/' + id + '?_format=json', {
          headers: {
            'Content-Type': 'application/hal+json',
            'X-CSRF-Token': this.userdata.user.csrf_token,
            'Authorization': 'Basic ' + this.userdata.auth,
          }
        })
        .then(response => {
          dataobject[parentObject] = {
            value: response.data.name[0].value,
            id: id,
            uuid: response.uuid[0].value,
          }
        })
        .catch(e => {
          console.log(e)
        })
    },
    getsupplierInfo(id, parentObject, loaded, dataobject) {
      axios.get('http://drupal.dd:8083/wheel/supplier/' + id + '?_format=json', {
          headers: {
            'Content-Type': 'application/hal+json',
            'X-CSRF-Token': this.userdata.user.csrf_token,
            'Authorization': 'Basic ' + this.userdata.auth,
          }
        })
        .then(response => {
          dataobject[parentObject] = {
            value: response.data.name[0].value,
            id: id,
            uuid: response.data.uuid[0].value,
          }
        })
        .catch(e => {
          console.log(e)
        })
    },
  },
  mounted() {}
}
