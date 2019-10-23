@extends('layouts.page')

@section('title', 'Home')

@section('content')

@if (request('contract_id'))
<div class="ui container vertically padded grid centered">
    <div class="sixteen wide mobile sixteen wide tablet twelve wide computer column">
        <div class="notification @if ($invoice) notification--positive @else notification--negative @endif raise rounded">
            <div class="notification__message">
                @if ($invoice)
                    <div class="notification__message-icon mr-h">
                        <i class="check circle outline icon"></i>
                    </div>
                    <div class="notification__message-text"><strong>{{ request('contract_id') }}</strong> found</div>
                @else 
                    <div class="notification__message-icon mr-h">
                        <i class="times circle outline icon"></i>
                    </div>
                    <div class="notification__message-text">Must enter valid contract ID</div>
                @endif
            </div>
            @if ($invoice)
                <div class="notification__action">
                    <a href="{{ route('invoice.show',['invoice' => $invoice]) }}" class="ui mini basic positive button button--rounded">View Contract</a>
                </div>
            @endif
            <div class="notification__close">
                <i class="times icon"></i>
            </div>
        </div>
    </div>
</div>
@endif
<div class="ui container vertically padded grid pt-2">
    <div class="row centered pt-0">
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
                                    <input type="text" name="business_contact_number" placeholder="Contact Number (optional) " aria-label="Contact Number">
                                </div>
                                <div class="field">
                                    <input type="text" name="btc_address" placeholder="BTC Address" aria-label="BTC Address">
                                </div>
                                <div class="field">
                                    <input type="text" name="btc_address_confirm" placeholder="Confirm BTC Address" aria-label="Confirm BTC Address">
                                </div>
                            </div>
                            <div class="sixteen wide mobile eight width tablet eight wide computer column">
                                <div class="field">
                                    <input type="text" name="client_name" placeholder="Client Name" aria-label="Client Name">
                                </div>
                                <div class="field">
                                    <input type="text" name="client_email" placeholder="Client Email" aria-label="Client Email">
                                </div>
                                <div class="field">
                                    <input type="text" name="client_contact_number" placeholder="Contact Number (optional) " aria-label="Contact Number">
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
                                                    <input class="text-right" type="text"  @change="updateAmount(key,'quantity',$event)" v-input-filter:number>
                                                </div>
                                            </td>
                                            <td data-label="Price" class="right aligned">
                                                <div class="field">
                                                    <input class="text-right" type="text" @change="updateAmount(key,'price',$event)" v-input-filter="options">
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
            <div class="converter raise rounded px-2 py-3 text-center">
                <h4 class="mb-2">1 BTC = 7,957.28 USD </h4>
                <div class="ui form">
                    <div class="two fields">
                        <div class="field">
                            <div class="ui right action input">
                                <input type="text" placeholder="From">
                                <div class="ui basic floating dropdown button">
                                    <div class="text"><i class="bitcoin icon mr-h"></i> BTC</div>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui right action input">
                                <input type="text" placeholder="To">
                                <div class="ui basic floating dropdown button">
                                    <div class="text"><strong>$</strong> USD</div>
                                    <i class="dropdown icon"></i>
                                    <div class="menu">
                                    <div class="item"><strong>$</strong> USD</div>
                                    <div class="item"><strong>$</strong> AUD</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field text-right">
                        <div class="ui small basic primary button button--rounded"><i class="sync alternate icon"></i>Convert</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row centered">
        <div class="sixteen wide mobile sixteen wide tablet twelve wide computer column">
            <div class="ui item invoice-actions">
                <button id="convertCurrencyBtn" class="ui small primary button button--rounded mr-1"><i class="calculator icon"></i> Show Converter</button>
                <button class="ui small secondary button button--rounded"><i class="paper plane outline icon"></i> Send Invoice</button>
            </div>
        </div>
    </div>
</div>

@endsection