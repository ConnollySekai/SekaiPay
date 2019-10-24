<template>
    <div class="converter raise rounded px-2 py-3 text-center">
        <div class="ui form">
            <div class="two fields">
                <div class="field">
                    <div class="ui right action input">
                        <input type="text" placeholder="From" v-model="btcInput" v-input-filter="options">
                        <div class="ui basic floating dropdown button from">
                            <div class="text">BTC</div>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="ui right action input">
                        <input type="text" placeholder="To" v-model="resultInput">
                        <div class="ui basic floating dropdown button to">
                            <div class="text">{{ to }}</div>
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                <div class="item" v-for="(item,key) in selection" :key="key">{{ item }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="two fields">
                <div class="field text-center">
                    <h4>1 BTC = {{ rate }} </h4>
                </div>
                <div class="field text-right">
                    <button class="ui small primary button button--rounded converter__button" @click="convertCurrency()"><i class="sync alternate icon" :class="{ rotation: loading }"></i>{{ btnText }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import inputFilter from 'vue-input-filter';

    import Bigjs from 'big.js';

    import filterOptions from './../filterOptions';

    export default {
        computed: {
            rate() {
                return `${this.toValue} ${this.ticker}`;
            }
        },
        data() {
            return {
                to: 'USD',
                ticker: 'USD',
                toValue: 0,
                btcInput:'',
                resultInput:'',
                selection: ['USD','EUR','GBP','JPY','AUD','CAD'],
                url: 'https://api.coinbase.com/v2/prices/spot?currency=',
                options: filterOptions.btc,
                loading: false,
                btnText: 'Convert'
            }
        },
        methods: {
            getRate(ticker) {
                return axios.get(this.url+ticker);
            },
            convertCurrency() {

                const vm = this;

                if (this.btcInput.length) {
                    
                    this.loading = true;
                    
                    this.btnText = 'Converting';

                    this.getRate(this.to).then(response => {
                        const data = response.data.data;

                        setTimeout(() => {
                            const amount = new Bigjs(data.amount);

                            vm.toValue = amount.toFixed(2);

                            vm.resultInput = amount.times(vm.btcInput).toFixed(2)

                            vm.ticker = vm.to;
                            
                            vm.loading = false;
                            
                            this.btnText = 'Convert';
                        }, 1000);
                    });
                }
            } 
        },
        mounted() {

            const vm = this;

            $('.ui.dropdown').dropdown({ 
                showOnFocus:false,
                onChange: (value, text, selectedItem) => {
                    const parent = selectedItem.parents('.dropdown');
                    
                    vm.to = value.toUpperCase();
                } 
            });

            this.getRate(this.ticker).then(response => {
                const data = response.data.data;

                vm.toValue = new Bigjs(data.amount).toFixed(2);
            });
        }
    }
</script>
