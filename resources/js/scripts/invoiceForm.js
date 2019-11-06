import Bigjs from 'big.js';

import Convert from 'satoshi-bitcoin';

import {IMaskComponent} from 'vue-imask';

import Form from 'form-backend-validation';

import Converter from './../components/Converter';

import {hideNotification, toggleSearchBar,toggleConverter, scrollToError} from './../common';

export default {
    components: {
        Converter,
        'imask-input': IMaskComponent
    },
    data: {
        currency: 'BTC',
        invoice: {
            item: {
                description: '',
                quantity: '1',
                price: '',
                price_in_satoshi: '',
                amount: ''
            },
            form: new Form({
                business_name:'',
                business_email: '',
                business_calling_code: '',
                business_mobile_number: '',
                btc_address: '',
                btc_address_confirmation: '',
                client_name: '',
                client_email: '',
                client_calling_code: '',
                client_mobile_number: '',
                notes: '',
                items: [{
                    description: '',
                    quantity: '1',
                    price: '',
                    price_in_satoshi: '',
                    amount: ''
                }]
    
            },{resetOnSuccess: false}),
            subtotal: 0,
            total: 0
        }
    },
    methods: {
        /* Add invoice item */
        addItem() {
            const item = {...this.invoice.item};
            
            this.invoice.form.items.push(item);
        },
        /* Compute total invoice price */
        computeTotal() {

            const subtotal = Object.values(this.invoice.form.items).reduce((total, {amount}) => {

                if (amount != '') {
                    let bigjs = new Bigjs(amount);

                    return bigjs.plus(total);
                }

                return 0;
            },0);

            this.invoice.subtotal = subtotal.toFixed();
            
            this.invoice.total = subtotal.toFixed();
        },
        /* Remove Invoice item */
        deleteItem(key) {

            this.invoice.form.items.splice(key,1);
            
            this.computeTotal();
        },
        /* Validates invoice then save on success */
        handleSubmit() {
    
            const vm = this;

            this.invoice.form.post(this.$refs.form.action).then(response => {
                
                if (response.message === 'success') {
                    document.location.href = '/invoice/'+response.contract_id;
                }
            }).catch(e => {
                if (vm.invoice.form.errors.any()) {
                    scrollToError(vm.invoice.form.errors.errors);
                }
            });
        },
        /* Computes amount based on item price * quantity */
        updateAmount(index) {

            let item = this.invoice.form.items[index];

            if (item.quantity != '' || item.price != '') {

                let price_in_satoshi = Convert.toSatoshi(String(item.price));

                let amount = price_in_satoshi * item.quantity;

                item.price_in_satoshi = price_in_satoshi;

                item.amount = new Bigjs(Convert.toBitcoin(amount)).toFixed();

                this.computeTotal();
            }
        }
    },
    mounted() {
   
        toggleConverter(this.trans('translations.show_converter'), this.trans('translations.hide_converter'));

        toggleSearchBar();

        hideNotification();
    }
}