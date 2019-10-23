/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import 'semantic-ui-sass';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

import inputFilter from 'vue-input-filter';

import PatternInput from 'vue-pattern-input';

import QRCode from 'qrcode';

import Convert from 'satoshi-bitcoin';

import Bigjs from 'big.js';

Vue.use(inputFilter);

const app = new Vue({
    el: '#app',
    components: {
        PatternInput
    },
    data: {
        invoice: {
            items: [{
                description: '',
                quantity: 1,
                price: '',
                amount: 0
            }],
            subtotal: 0,
            total: 0
        },
        currency: 'BTC',
        options: {
            legalReg : [/^(\d+)?([.]?\d{0,8})$/], 
            legalKeyCode: [8, 32, 37, 38, 39, 40, 46, 190],
            legalKeyCodeRange: [
                    {
                        min: 65,
                        max: 90
                    },
                    {
                        min: 48,
                        max: 57
                    },
                    {
                        min: 96,
                        max: 105
                    }
                ]
        }
    },
    methods: {
        addItem() {
            this.invoice.items.push({
                description: '',
                quantity: 1,
                price: '',
                amount: 0
            });
        },
        computeTotal() {

            const subtotal = Object.values(this.invoice.items).reduce((total, {amount}) => {

                let bigjs = new Bigjs(amount);

                return bigjs.plus(total);
            },0);

            this.invoice.subtotal = subtotal.toFixed();
            this.invoice.total = subtotal.toFixed();
        },
        deleteItem(key) {
            this.invoice.items.splice(key,1);
            this.computeTotal();
        },
        setPrice(price) {

            /* Check if there's no 0 before decimal */
            if (price.startsWith('.')) {
                price = '0'+price;
            }

            console.log(price.indexOf('.'),'indexof');

            if (price.indexOf('.') > -1) {
                
                const string  = price.split('.');

                let number = string[0];

                console.log(string[1].length, "length");

                /* work around for inputfilter adding 9th value */
                if (string[1].length === 9) {

                    
                    let decimals = string[1].substring(0, string[1].length - 1);

                    return string[0]+'.'+decimals;
                }
            }

            return price;
        },
        updateAmount(index,key, evt) {

            let item = this.invoice.items[index];

            if (key === 'quantity') {
                item.quantity = evt.target.value;
            } else {
                item.price = evt.target.value;
            }

            if (item.quantity != 0 || item.price != 0) {

                let price = item.price;

                let amount = Convert.toSatoshi(String(price)) * item.quantity;
                
                item.price = price;
                
                item.amount = new Bigjs(Convert.toBitcoin(amount)).toFixed();

                this.computeTotal();
            }

            console.log(this.invoice.items);
        }
    },
    mounted() {
        $('.ui.dropdown').dropdown({ showOnFocus:false });

        const canvas = document.getElementById('qrCanvas');

        const btcAddress = document.getElementById('btcAddress');

        QRCode.toCanvas(canvas, btcAddress.value,{ width:146 }, function (error) {
            if (error) console.error(error)
            console.log('success!');
        });

        $('#searchOpenBtn').click(function() {
            $('.site-search__mobile').addClass('active');
            $('.site-logo, .site-search').removeClass('active');
        });

        $('#searchCloseBtn').click(function() {
            $('.site-search__mobile').removeClass('active');
            $('.site-logo, .site-search').addClass('active');
        });

        $('#convertCurrencyBtn').click(function() {
            $('.ui.modal').modal('show');
        });
    }
});
