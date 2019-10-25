/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import 'semantic-ui-sass';

import inputFilter from 'vue-input-filter';

import QRCode from 'qrcode';

import filterOptions from './filterOptions';

import Convert from 'satoshi-bitcoin';

import Bigjs from 'big.js';

import Form from 'form-backend-validation';

import Converter from './components/Converter';
import Axios from 'axios';

Vue.use(inputFilter);

const app = new Vue({
    el: '#app',
    components: {
        Converter
    },
    data: {
        invoice: {
            data: {},
            subtotal: 0,
            total: 0
        },
        currency: 'BTC',
        options: {
            btc: filterOptions.getOption('btc')
        },
        form: new Form({
            business_name:'',
            business_email: '',
            business_mobile_number: '',
            btc_address: '',
            btc_address_confirmation: '',
            client_name: '',
            client_email: '',
            client_mobile_number: '',
            notes: '',
            items: [{
                description: '',
                quantity: 1,
                price: '',
                price_in_satoshi: '',
                amount: 0
            }]

        },{resetOnSuccess: false})
    },
    methods: {
        addItem() {
            this.form.items.push({
                description: '',
                quantity: 1,
                price: '',
                price_in_satoshi: '',
                amount: 0
            });
        },
        computeTotal() {

            const subtotal = Object.values(this.form.items).reduce((total, {amount}) => {

                let bigjs = new Bigjs(amount);

                return bigjs.plus(total);
            },0);

            this.invoice.subtotal = subtotal.toFixed();
            
            this.invoice.total = subtotal.toFixed();
        },
        deleteItem(key) {
            this.form.items.splice(key,1);
            this.computeTotal();
        },
        getItems() {

            const vm = this;

            const contract_id = window.location.pathname.split("/").pop();

            axios.get('/invoice/get/data',{
                params: {
                    contract_id
                }
            }).then(response => {
                
                const data = response.data;

                vm.invoice.data = data.invoice;
            }); 
        },
        handleSubmit() {
    
            this.form.post(this.$refs.form.action).then(response => {
                
                if (response.message === 'success') {
                    document.location.href = '/invoice/'+response.contract_id;
                }
            });
        },
        setPrice(price) {

            /* Check if there's no 0 before decimal */
            if (price.startsWith('.')) {
                price = '0'+price;
            }

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

            let item = this.form.items[index];

            if (key === 'quantity') {
                item.quantity = evt.target.value;
            } else {
                item.price = evt.target.value;
            }

            if (item.quantity != 0 || item.price != 0) {

                let price = item.price;

                let satoshi = Convert.toSatoshi(String(price));

                let amount = satoshi * item.quantity;

                item.price_in_satoshi = satoshi;
                
                item.price = price;
                
                item.amount = new Bigjs(Convert.toBitcoin(amount)).toFixed();

                this.computeTotal();
            }
        }
    },
    mounted() {

        const vm = this;
    
        const canvas = document.getElementById('qrCanvas');

        /* const btcAddress = document.getElementById('btcAddress');

        QRCode.toCanvas(canvas, btcAddress.value,{ width:146 }, function (error) {
            if (error) console.error(error)
            console.log('success!');
        }); */


        this.getItems();
        $('#searchOpenBtn').click(function() {
            $('.site-search__mobile').addClass('active');
            $('.site-logo, .site-search').removeClass('active');
        });

        $('#searchCloseBtn').click(function() {
            $('.site-search__mobile').removeClass('active');
            $('.site-logo, .site-search').addClass('active');
        });

        $('#showConverterBtn').click(function() {

            const converter = $('.converter');

            if (converter.is(':hidden')) {
                
                $(this).find('span').text('Hide Converter');

                $(this).removeClass('primary');
            } else {
                $(this).find('span').text('Show Converter');

                $(this).addClass('primary');
            }

            $('.converter').transition('fade down');
        });

        $('.notification__close').click(function(){

            $('.notification').transition('fade down');
        });
    }
});
