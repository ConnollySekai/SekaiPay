@extends('layouts.page')

@section('title', 'Home')

@section('content')
<div class="ui container vertically padded grid py-3">
    <div class="row centered">
        <div class="sixteen wide mobile sixteen wide tablet twelve wide computer column">
            <div class="invoice-view raise rounded">
                <form class="ui form">
                    <div class="ui column grid">
                        <div class="row">
                            <div class="column">
                                <h2>Invoice</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="sixteen wide mobile eight width tablet eight wide computer column">
                                <div class="field">
                                    <input type="text" name="business_name" placeholder="Business Name" aria-label="Business Name">
                                </div>
                                <div class="field">
                                    <input type="text" name="business_email" placeholder="Business Email" aria-label="Business Email">
                                </div>
                                <div class="field">
                                    <input type="text" name="btc_address" placeholder="BTC Address" aria-label="BTC Address">
                                </div>
                            </div>
                            <div class="sixteen wide mobile eight width tablet eight wide computer column">
                                <div class="field">
                                    <input type="text" name="client_name" placeholder="Client Name" aria-label="Client Name">
                                </div>
                                <div class="field">
                                    <input type="text" name="client_email" placeholder="Client Email" aria-label="Client Email">
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
                                        <tr class="invoice-item" v-for="(item,key) in invoice.items" :key="key">
                                            <td data-label="Description">
                                                <div class="field">
                                                    <input type="text" v-model="item.description">
                                                </div>
                                            </td>
                                            <td data-label="Quantity" class="right aligned">
                                                <div class="field">
                                                    <input class="text-right" type="text" v-model="item.quantity" @change="updateAmount(key)" v-input-filter:number>
                                                </div>
                                            </td>
                                            <td data-label="Price" class="right aligned">
                                                <div class="field">
                                                    <input class="text-right" type="text" v-model="item.price" @change="updateAmount(key)" v-input-filter="options">
                                                </div>
                                            </td>
                                            <td v-cloak data-label="Amount" class="right aligned"><div class="invoice-item__amount">@{{ item.amount }} <i class="times icon invoice-item__delete-btn" @click="deleteItem(key)" v-show="invoice.items.length != 1"></i></div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row pt-0">
                            <div class="sixteen wide mobile eight width tablet eight wide computer column">
                                <button type="button" class="ui mini basic primary button button__rounded mr-1" @click="addItem()"><i class="plus icon"></i> Add Item</button>
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
                                    <textarea name="notes" placeholder="Notes(Optional)" aria-label="Notes" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row centered">
        <div class="sixteen wide mobile sixteen wide tablet twelve wide computer column">
            <div class="ui item invoice-actions">
                <button id="convertCurrencyBtn" class="ui small primary button button__rounded mr-1"><i class="sync alternate icon"></i> Convert Currency</button>
                <button class="ui small secondary button button__rounded"><i class="paper plane outline icon"></i> Send Invoice</button>
            </div>
        </div>
    </div>
</div>

@endsection