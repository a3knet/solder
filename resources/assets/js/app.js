
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('release-picker', require('./components/ReleasePicker.vue'));
Vue.component('release-table', require('./components/ReleaseTable.vue'));
Vue.component('build-table', require('./components/BuildTable.vue'));
Vue.component('passport-personal-access-tokens', require('./components/PersonalAccessTokens.vue'));
Vue.component('assistant', require('./components/Assistant'));
Vue.component('tabs', require('./components/Tabs.vue'));
Vue.component('tab', require('./components/Tab.vue'));

Vue.filter('prettyBytes', function (num) {
    // jacked from: https://github.com/sindresorhus/pretty-bytes
    if (typeof num !== 'number' || isNaN(num)) {
        return '';
    }
    
    var exponent;
    var unit;
    var neg = num < 0;
    var units = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    
    if (neg) {
        num = -num;
    }
    
    if (num < 1) {
        return (neg ? '-' : '') + num + ' B';
    }
    
    exponent = Math.min(Math.floor(Math.log(num) / Math.log(1000)), units.length - 1);
    num = (num / Math.pow(1000, exponent)).toFixed(2) * 1;
    unit = units[exponent];
    
    return (neg ? '-' : '') + num + ' ' + unit;
});

const app = new Vue({
    el: '#app'
});
