@extends('layouts.page')

@section('title', 'Home')

@section('content')

<form action="{{ route('invoice.store') }}" method="post" class="ui form" ref="form" @submit.prevent="handleSubmit()" v-cloak>
    <div class="ui container vertically padded grid">
        <div class="row centered pt-0">
            <div class="sixteen wide mobile sixteen wide tablet twelve wide computer column">
                @if (request('contract_id'))
                    @include('partials.notification',['invoice' => $invoice])
                @endif
                <div class="invoice-view raise rounded mt-2">
                    <div class="ui column grid">
                        <div class="row">
                            <div class="column">
                                <h2>Invoice</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="sixteen wide mobile eight width tablet eight wide computer column">
                                <div class="field" :class="form.errors.has('business_name') ? 'error':''">
                                    <label for="businessName">Business Name</label>
                                    <input type="text" id="businessName" name="business_name" placeholder="Company XYZ" v-model="form.business_name">
                                    <div v-if="form.errors.has('business_name')" class="ui mini basic negative pointing prompt label visible">@{{ form.errors.first('business_name') }}</div>
                                </div>
                                <div class="field" :class="form.errors.has('business_email') ? 'error':''">
                                    <label for="businessEmail">Business Email</label>
                                    <input type="text" id="businessEmail" name="business_email" placeholder="youremail@example.com" v-model="form.business_email">
                                    <div v-if="form.errors.has('business_email')" class="ui mini basic negative pointing prompt label visible">@{{ form.errors.first('business_email') }}</div>
                                </div>
                                <div class="field" :class="form.errors.has('business_mobile_number') ? 'error':''">
                                    <label for="businessMobileNumber">Mobile Number <small>(Optional)</small></label>
                                    <input type="text" id="businessMobileNumber" name="business_contact_number" placeholder="+12025550111"  v-model="form.business_mobile_number">
                                    <div v-if="form.errors.has('business_mobile_number')" class="ui mini basic negative pointing prompt label visible">@{{ form.errors.first('business_mobile_number') }}</div>
                                </div>
                                <div class="field" :class="form.errors.has('btc_address') ? 'error':''">
                                    <label for="btcAddress">BTC Address</label>
                                    <input type="text" id="btcAddress" name="btc_address" placeholder="1AoojGN94Uab8mT2LHDnbsuM4ojHnm85jA" v-model="form.btc_address">
                                    <div v-if="form.errors.has('btc_address')" class="ui mini basic negative pointing prompt label visible">@{{ form.errors.first('btc_address') }}</div>
                                </div>
                                <div class="field">
                                    <label for="btcAddressConfirmation">Confirm BTC Address</label>
                                    <input type="text" id="btcAddressConfirmation" name="btc_address_confirmation" placeholder="1AoojGN94Uab8mT2LHDnbsuM4ojHnm85jA" v-model="form.btc_address_confirmation">
                                </div>
                            </div>
                            <div class="sixteen wide mobile eight width tablet eight wide computer column">
                                <div class="field" :class="form.errors.has('client_name') ? 'error':''">
                                    <label for="clientName">Client Name</label>
                                    <input type="text" id="clientName" name="client_name" placeholder="John Doe" v-model="form.client_name">
                                    <div v-if="form.errors.has('client_name')" class="ui mini basic negative pointing prompt label visible">@{{ form.errors.first('client_name') }}</div>
                                </div>
                                <div class="field" :class="form.errors.has('client_email') ? 'error':''">
                                    <label for="clientEmail">Client Email</label>
                                    <input type="text" id="clientEmail" name="client_email" placeholder="clientemail@example.com"  v-model="form.client_email">
                                    <div v-if="form.errors.has('client_email')" class="ui mini basic negative pointing prompt label visible">@{{ form.errors.first('client_email') }}</div>
                                </div>
                                <div class="field" :class="form.errors.has('client_mobile_number') ? 'error':''">
                                    <label for="clientMobileNumber">Mobile Number <small>(Optional)</small></label>
                                    <input type="text" name="client_mobile_number" placeholder="Contact Number (optional) " v-model="form.client_mobile_number">
                                    <div v-if="form.errors.has('client_mobile_number')" class="ui mini basic negative pointing prompt label visible">@{{ form.errors.first('client_mobile_number') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ui divider"></div>
                    <div class="ui column grid">
                        <div class="row">
                            <div class="sixteen wide column">
                                <table class="ui basic table table-primary table__borderless mt-h">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th class="right aligned">Quantity</th>
                                            <th class="right aligned">Price</th>
                                            <th class="right aligned">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="invoice-item" v-for="(item,key) in form.items" :key="key">
                                            <td data-label="Description">
                                                <div class="field">
                                                    <input type="text" v-model="item.description">
                                                </div>
                                            </td>
                                            <td data-label="Quantity" class="right aligned">
                                                <div class="field">
                                                    <input class="text-right" type="text"  @change="updateAmount(key,'quantity',$event)" v-input-filter:number>
                                                </div>
                                            </td>
                                            <td data-label="Price" class="right aligned">
                                                <div class="field">
                                                    <input class="text-right" type="text" @change="updateAmount(key,'price',$event)" v-input-filter="options.btc">
                                                </div>
                                            </td>
                                            <td v-cloak data-label="Amount" class="right aligned"><div class="invoice-item__amount">@{{ item.amount }} <i class="times icon invoice-item__delete-btn" @click="deleteItem(key)" v-show="form.items.length != 1"></i></div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row pt-0">
                            <div class="sixteen wide mobile eight width tablet eight wide computer column">
                                <button type="button" class="ui mini basic primary button button--rounded mr-1" @click="addItem()"><i class="plus icon"></i> Add Item</button>
                            </div>
                            <div class="sixteen wide mobile eight width tablet eight wide computer column">
                                <div class="invoice-summary">
                                    <div class="invoice-summary__row">
                                        <div><span>Subtotal</span></div>
                                        <div v-cloak><strong>@{{ invoice.subtotal }}</strong></div>
                                    </div>
                                    <div class="invoice-summary__row invoice-summary__total">
                                        <div><span>Total</span></div>
                                        <div v-cloak><strong>@{{ `${currency} ${invoice.total}` }}</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ui divider"></div>
                    <div class="ui column grid">
                        <div class="row">
                            <div class="sixteen wide mobile eight width tablet eight wide computer column"></div>
                            <div class="sixteen wide mobile eight width tablet eight wide computer column">
                                <div class="field">
                                    <label for="notes">Notes <small>(Optional)</small></label>
                                    <textarea id="notes" name="notes" rows="4" v-model="form.notes"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row centered py-0">
            <div class="sixteen wide mobile sixteen wide tablet twelve wide computer column">
                <converter class="my-2"></converter>
            </div>
        </div>
        <div class="row centered">
            <div class="sixteen wide mobile sixteen wide tablet twelve wide computer column">
                <div class="ui item invoice-actions">
                    <button type="button" id="showConverterBtn" class="ui small primary button button--rounded mr-1"><i class="calculator icon"></i> <span>Show Converter</span></button>
                    <button type="submit" id="sendInvoiceBtn" class="ui small secondary button button--rounded"><i class="paper plane outline icon"></i> Send Invoice</button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection