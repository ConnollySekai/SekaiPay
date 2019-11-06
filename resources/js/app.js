/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import 'semantic-ui-sass';

import PageScript from './setup';

Vue.prototype.trans = (string, args) => {
    
    let value = _.get(window.i18n, string);

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });
    return value;
};

console.log(window.i18n);

const app = new Vue({
    el: '#app',
    mixins: [PageScript],
    mounted() {
        $('.language-switcher .ui.dropdown').dropdown({
            showOnFocus:false,
            onChange: (value, text, selectedItem) => {
                axios.get('/setLocale',{
                    params: {
                        locale: value
                    }
                }).then(response => {
                    if (response.data.success === true) {
                        location.reload();
                    }
                })
            }
        });
    }
});