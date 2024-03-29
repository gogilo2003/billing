/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('domains', require('./components/Domains.vue').default);
Vue.component('products', require('./components/Products.vue').default);
Vue.component('import', require('./components/Import.vue').default);
Vue.component('invoices', require('./components/invoice/List.vue').default);
Vue.component('quotations', require('./components/Quotations/List.vue').default);
Vue.component('clients', require('./components/Clients/List.vue').default);
Vue.component('accounts', require('./components/Accounts/List.vue').default);
Vue.component('modal', require('./components/shared/Modal.vue').default)
import { library } from '@fortawesome/fontawesome-svg-core'
import { faEllipsisV, faEllipsisH } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

Vue.component('font-awesome-icon', FontAwesomeIcon)

library.add(faEllipsisV, faEllipsisH)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
