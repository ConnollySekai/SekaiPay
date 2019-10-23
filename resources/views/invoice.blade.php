@extends('layouts.page')

@section('title', 'Home')

@section('content')
<div class="ui container vertically padded grid py-3">
    <div class="row centered">
        <div class="sixteen wide mobile sixteen wide tablet twelve wide computer column">
            <div class="invoice-view raise rounded">
                <div class="ui column grid">
                    <div class="row">
                        <div class="column">
                            <h2>Invoice</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="sixteen wide mobile eight width tablet eight wide computer column">
                            <div class="mb-1">
                                <label for="contractId">Contract ID</label>
                                <span id="contractId">{{ $invoice->contract_id }}</span>
                            </div>
                            <div class="mb-h">
                                <label for="fromInfo">From</label>
                                <div id="fromInfo">
                                    <span class="d-block">{{ $invoice->business_name }}</span>
                                    <span class="d-block">{{ $invoice->business_email }}</span>
                                    <span class="d-block">{{ $invoice->business_contact_number }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="sixteen wide mobile eight width tablet eight wide computer column">
                            <div class="mb-1">
                                <label for="invoiceDate">Invoice Date</label>
                                <span id="invoiceDate">10-21-18</span>
                            </div>
                            <div class="mb-h">
                                <label for="toInfo">To</label>
                                <div id="toInfo">
                                    <span class="d-block">{{ $invoice->client_name }}</span>
                                    <span class="d-block">{{ $invoice->client_email }}</span>
                                    <span class="d-block">{{ $invoice->client_contact_number }}</span>
                                </div>
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
                                    <tr>
                                        <td data-label="Description">James</td>
                                        <td data-label="Quantity" class="right aligned">24</td>
                                        <td data-label="Price" class="right aligned">12</td>
                                        <td data-label="Amount" class="right aligned">12344</td>
                                    </tr>
                                    <tr>
                                        <td data-label="Description">James</td>
                                        <td data-label="Quantity" class="right aligned">24</td>
                                        <td data-label="Price" class="right aligned">12</td>
                                        <td data-label="Amount" class="right aligned">12344</td>
                                    </tr>
                                    <tr>
                                        <td data-label="Description">James</td>
                                        <td data-label="Quantity" class="right aligned">24</td>
                                        <td data-label="Price" class="right aligned">12</td>
                                        <td data-label="Amount" class="right aligned">12344</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row pt-0">
                        <div class="sixteen wide mobile eight width tablet eight wide computer column">
                        
                        </div>
                        <div class="sixteen wide mobile eight width tablet eight wide computer column">
                            <div class="invoice-summary">
                                <div class="invoice-summary__row">
                                    <div><span>Subtotal</span></div>
                                    <div><strong>123456</strong></div>
                                </div>
                                <div class="invoice-summary__row invoice-summary__total">
                                    <div><span>Total</span></div>
                                    <div><strong>123456</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui divider"></div>
                <div class="ui column grid">
                    <div class="row">
                        <div class="sixteen wide mobile eight width tablet eight wide computer column">
                            <div class="text-center">
                                <label for="">BTC Address</label>
                                <a href="https://chain.so/address/BTC/{{ $invoice->btc_address }}" target="_blank" class="d-block break-word" rel="noreferrer">{{ $invoice->btc_address }}</a>
                                <canvas id="qrCanvas"></canvas>
                                <input id="btcAddress" type="hidden" value="{{ $invoice->btc_address }}">
                            </div>
                        </div>
                        <div class="sixteen wide mobile eight width tablet eight wide computer column">
                            <label for="notes">Notes</label>
                            <p>{{ $invoice->notes }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row centered">
        <div class="sixteen wide mobile sixteen wide tablet twelve wide computer column">
            <div class="ui item invoice-actions">
                <button id="convertCurrencyBtn" class="ui small primary button button--rounded mr-1"><i class="calculator icon"></i> Show Converter</button>
                <button class="ui tiny negative button button__rounded"><i class="file pdf outline icon"></i> Download PDF</button>
            </div>
        </div>
    </div>
</div>

@endsection