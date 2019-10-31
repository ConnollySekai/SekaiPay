@extends('layouts.page')

@section('title', 'Home')

@section('content')
<div class="ui container vertically padded grid pb-3">
    <div class="row centered pt-0">
        <div class="sixteen wide mobile sixteen wide tablet twelve wide computer column">
            <div class="invoice-view raise rounded mt-2">
                <input type="hidden" ref="invoiceId" value="{{ $invoice->id }}">
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
                                    <span class="d-block">{{ $invoice->business_mobile_number }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="sixteen wide mobile eight width tablet eight wide computer column">
                            <div class="mb-1">
                                <label for="invoiceDate">Invoice Date</label>
                                <span id="invoiceDate">{{ $invoice->created_at->format('m-d-Y') }}</span>
                            </div>
                            <div class="mb-h">
                                <label for="toInfo">To</label>
                                <div id="toInfo">
                                    <span class="d-block">{{ $invoice->client_name }}</span>
                                    <span class="d-block">{{ $invoice->client_email }}</span>
                                    <span class="d-block">{{ $invoice->client_mobile_number }}</span>
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
                                    @if ($invoice->items->count())
                                        @php ($amount = 0)
                                        @foreach ($invoice->items as $item)
                                            @php ($amount = bcadd($amount,bcmul($item->quantity,$item->price_in_satoshi)))
                                            <tr>
                                                <td data-label="Description">{{ $item->description }}</td>
                                                <td data-label="Quantity" class="right aligned">{{ $item->quantity }}</td>
                                                <td data-label="Price" class="right aligned">{{ format_number($item->priceInBtc) }}</td>
                                                <td data-label="Amount" class="right aligned">{{ format_number(compute_amount($item->price_in_satoshi, $item->quantity)) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
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
                                    <div><strong>{{ format_number(to_btc((string)$amount)) }}</strong></div>
                                </div>
                                <div class="invoice-summary__row invoice-summary__total">
                                    <div><span>Total</span></div>
                                    <div><strong>{{ format_number(to_btc((string)$amount)) }}</strong></div>
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
                                <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(146)->generate($invoice->btc_address)) }} ">
                            </div>
                        </div>
                        <div class="sixteen wide mobile eight width tablet eight wide computer column">
                            @if ($invoice->notes)
                                <label for="notes">Notes</label>
                                <p>{{ $invoice->notes }}</p>
                            @endif
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
                <button type="button" id="converterBtn" class="ui small primary button button--rounded mr-1"><i class="calculator icon"></i> <span>Show Converter</span></button>
                <a href="{{ route('invoice.downloadPDF',['invoice' => $invoice]) }}" class="ui tiny negative button button--rounded"><i class="file pdf outline icon"></i> Download PDF</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page', 'invoice_view')