<template>
    <div id="converter" class="converter raise rounded px-2 py-3 text-center">
        <div class="ui form">
            <div class="converter__inputs mb-1">
                <div class="converter__input">
                    <div class="field mb-0">
                        <div class="ui right action input fluid">
                            <imask-input id="leftInput" v-model="input.left" :mask="/^(\d+)?([.]?\d{0,8})$/" @change="updateResultOutput('right')"/> 
                            <div class="ui basic floating dropdown button from">
                                <div class="text">{{ from_text }}</div>
                                <i class="dropdown icon"></i>
                                <div class="menu">
                                    <div class="item" v-for="(item,key) in tickerList" :key="key" :data-value="item.ticker">{{ item.text }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="converter__arrow">
                    <i class="random icon" :class="{'horizontally flipped ': resultOutput === 'left'}"></i>
                </div>
                <div class="converter__input">
                    <div class="field mb-0">
                        <div class="ui right action input fluid">
                            <imask-input id="rightInput" v-model="input.right" :mask="/^(\d+)?([.]?\d{0,8})$/" @change="updateResultOutput('left')"/> 
                            <div class="ui basic floating dropdown button to">
                                <div>{{ to_text }}</div>
                                <i class="dropdown icon" v-show="toOptions.length"></i>
                                <div class="menu" v-show="toOptions.length">
                                    <div class="item" v-for="(item,key) in toOptions" :key="key" :data-value="item.ticker">{{ item.text }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="two fields">
                <div class="field text-center">
                    <h4> {{ rateDisplay }} </h4>
                </div>
                <div class="field text-right">
                    <button type="button" class="ui small primary button button--rounded converter__button" @click="convertCurrency()"><i class="sync alternate icon" :class="{ rotation: loading }"></i>{{ btnText }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import {IMaskComponent} from 'vue-imask';

    import Bigjs from 'big.js';

    import Convert from 'satoshi-bitcoin';

    export default {
        components: {
            'imask-input': IMaskComponent
        },
        computed: {
            rateDisplay() {
                return `${this.rateInfo.amount} ${this.rateInfo.from} = ${this.rateInfo.rate} ${this.rateInfo.to}`
            },
            selectedCurrency() {
                if (this.from === 'BTC') {
                    return this.to;
                }

                return this.from;
            } 
        },
        data() {
            return {
                from: 'USD',
                from_text: this.trans('translations.ticker.usd'),
                to: 'BTC',
                to_text: this.trans('translations.ticker.btc'),
                toOptions: [],
                toValue: 0,
                tickerList: [
                    {
                        ticker: 'BTC',
                        text: this.trans('translations.ticker.btc')
                    },
                    {
                        ticker: 'USD',
                        text: this.trans('translations.ticker.usd')
                    },
                    {
                        ticker: 'EUR',
                        text: this.trans('translations.ticker.eur')
                    },
                    {
                        ticker: 'GBP',
                        text: this.trans('translations.ticker.gbp')
                    },
                    {
                        ticker: 'JPY',
                        text: this.trans('translations.ticker.jpy')
                    },
                    {
                        ticker: 'AUD',
                        text: this.trans('translations.ticker.aud')
                    },
                    {
                        ticker: 'CAD',
                        text: this.trans('translations.ticker.cad')
                    },
                    {
                        ticker: 'HKD',
                        text: this.trans('translations.ticker.hkd')
                    },
                    {
                        ticker: 'SGD',
                        text: this.trans('translations.ticker.sgd')
                    },
                    {
                        ticker: 'KRW',
                        text: this.trans('translations.ticker.krw')
                    },
                    {
                        ticker: 'CNY',
                        text: this.trans('translations.ticker.cny')
                    }
                ],
                loading: false,
                btnText: this.trans('translations.convert'),
                rateInfo: {
                    amount:'1',
                    rate: '',
                    from: this.trans('translations.ticker.btc'),
                    to: this.trans('translations.ticker.usd')
                },
                input: {
                    left: '',
                    right: '',
                },
                resultOutput: 'right'
            }
        },
        methods: {
            convertCurrency() {

                const vm = this;

                const amount = (this.resultOutput === 'right') ? this.input.left: this.input.right;

                const from = (this.resultOutput === 'right') ? this.from : this.to;

                const from_text = (this.resultOutput === 'right') ? this.from_text : this.to_text;

                const to = (this.resultOutput === 'right') ? this.to : this.from;

                const to_text = (this.resultOutput === 'right') ? this.to_text : this.from_text;

                if (amount.length) {
                    this.loading = true;

                    this.btnText = this.trans('translations.converting');

                    this.getRate({
                        amount,
                        from,
                        to
                    }).then(response => {

                        const data = response.data;

                        if (vm.resultOutput === 'right') {

                            vm.input.right = data.total;
                        } else {
                            vm.input.left = data.total;
                        }

                        vm.rateInfo.from = from_text;

                        vm.rateInfo.to = to_text;

                        vm.rateInfo.rate = (amount === '1') ? data.total : data.rate;
                            
                        vm.loading = false;
                        
                        this.btnText = this.trans('translations.convert');

                    });
                }
            },
            getRate(data) {

                const url = '/api/converter';

                return axios.get(url,{
                    params: data
                });
            },
    
            setToOptions() {

                const selection = [...this.tickerList];

                let newSelection = [];

                if (this.from === 'BTC') {

                    for(let i = 0; i < selection.length; i++) {

                        if (selection[i].ticker !== 'BTC') {
                            
                            let ticker = selection[i];
                        
                            let isActive = (selection[i] === 'USD') ? true: false;
                        
                            newSelection.push({
                                ticker: ticker.ticker,
                                text: ticker.text,
                                isActive
                            });
                        }   
                    }

                    this.to = 'USD';
                    this.to_text = this.trans('translations.ticker.usd');
                } else {
                    this.to = 'BTC';
                    this.to_text = this.trans('translations.ticker.btc');
                }

                return newSelection;
            },
            updateResultOutput(position) {

                this.resultOutput = position;

                this.convertCurrency();
            }
        },
        mounted() {

            const vm = this;

            vm.toOptions = vm.setToOptions();

            $('.converter .ui.dropdown').dropdown({ 
                showOnFocus:false,
                onChange: (value, text, selectedItem) => {
                    const parent = selectedItem.parents('.dropdown');

                    if (parent.hasClass('from')) {
                        
                        vm.from = value.toUpperCase();

                        vm.from_text = text;
                        
                        vm.toOptions = vm.setToOptions();

                        vm.resultOutput = 'right';
                        
                    } else {
                        vm.to = value.toUpperCase();

                        vm.to_text = text;

                        vm.resultOutput = 'left';
                    }

                    vm.totalRate = '';

                } 
            });

            this.getRate({
                amount: '1',
                from: 'BTC',
                to: 'USD'
            }).then(response => {

                const data = response.data;

                this.rateInfo.rate = response.data.total;
            });
        }
    }
</script>
