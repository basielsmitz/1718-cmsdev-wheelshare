import Vue from 'vue'
import Router from 'vue-router'
import Overview from '@/components/overview/Overview'
import Reservation from '@/components/overview/Reservation'
import Vehicle from '@/components/overview/Vehicle'
import NewVehicle from '@/components/supplier/NewVehicle'
import Supplier from '@/components/supplier/Supplier'
import SupplierOverview from '@/components/supplier/SupplierOverview'
import SupplierVehicle from '@/components/supplier/SupplierVehicle'
import VehicleEdit from '@/components/supplier/VehicleEdit'
import User from '@/components/user/User'
import UserDetail from '@/components/user/UserDetail'
import UserDetailEdit from '@/components/user/UserDetailEdit'
import UserHistory from '@/components/user/UserHistory'
import Login from '@/components/Login'
import Register from '@/components/Register'

Vue.use(Router)

export default new Router({
  routes: [{
    path: '/',
    name: 'Overview',
    component: Overview
  }, {
    //   path: '/overzicht',
    //   name: 'Overview',
    //   component: Overview
    // },{
    path: '/overzicht/wagen/:vehicleId/',
    name: 'Vehicle',
    component: Vehicle,
  }, {
    path: '/overzicht/wagen/:vehicleId/reserveer',
    name: 'Reservation',
    component: Reservation
  }, {
    path: '/gebruiker',
    name: 'User',
    component: User
  }, {
    path: '/gebruiker/detail',
    name: 'UserDetail',
    component: UserDetail
  }, {
    path: '/gebruiker/detail/edit',
    name: 'UserDetailEdit',
    component: UserDetailEdit
  }, {
    path: '/gebruiker/geschiedenis',
    name: 'UserHistory',
    component: UserHistory
  }, {
    path: '/aanbieder/:supplierId/',
    name: 'Supplier',
    component: Supplier,
  }, {
    path: '/aanbieder/:supplierId/overzicht/',
    name: 'SupplierOverview',
    component: SupplierOverview
  }, {
    path: '/aanbieder/:supplierId/overzicht/:vehicleId',
    name: 'SupplierVehicle',
    component: SupplierVehicle,
  }, {
    path: '/aanbieder/:supplierId/overzicht/nieuw',
    name: 'NewVehicle',
    component: NewVehicle
  }, {
    path: '/aanbieder/:supplierId/overzicht/:vehicleId/edit',
    name: 'VehicleEdit',
    component: VehicleEdit
  }, {
    path: '/registreer',
    name: 'Register',
    component: Register
  }, {
    path: '/login',
    name: 'Login',
    component: Login
  }]
})
