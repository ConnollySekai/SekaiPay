@extends('layouts.page-ads')

@section('title', trans('translations.invoice'))

@section('content')
    @if (session('not_found'))
        @include('partials.notification')
    @endif
    <div class="invoice-view raise rounded my-2">
        <input type="hidden" ref="invoiceId" value="{{ $invoice->id }}">
        <div class="ui column grid">
            <div class="row">
                <div class="column">
                    <h2>{{ trans('translations.invoice') }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="sixteen wide mobile eight width tablet eight wide computer column">
                    <div class="mb-1">
                        <label for="contractId">{{ trans('translations.contract_id') }}</label>
                        <span id="contractId">{{ $invoice->contract_id }}</span>
                    </div>
                    <div class="mb-h">
                        <label for="fromInfo">{{ trans('translations.from') }}</label>
                        <div id="fromInfo">
                            <span class="d-block">{{ $invoice->business_name }}</span>
                            <span class="d-block">{{ $invoice->business_email }}</span>
                            <!--  <span class="d-block">{{ $invoice->business_mobile_number }}</span> -->
                        </div>
                    </div>
                </div>
                <div class="sixteen wide mobile eight width tablet eight wide computer column">
                    <div class="mb-1">
                        <label for="invoiceDate">{{ trans('translations.invoice_date') }}</label>
                        <span id="invoiceDate">{{ $invoice->created_at->format('m-d-Y') }}</span>
                    </div>
                    <div class="mb-h">
                        <label for="toInfo">{{ trans('translations.to') }} </label>
                        <div id="toInfo">
                            <span class="d-block">{{ $invoice->client_name }}</span>
                            <span class="d-block">{{ $invoice->client_email }}</span>
                            <!-- <span class="d-block">{{ $invoice->client_mobile_number }}</span> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui divider"></div>
        <div class="ui column grid">
            <div class="row">
                <div class="sixteen wide column">
                    <table class="invoice-items ui basic table table-primary table__borderless mt-h">
                        <thead>
                            <tr class="invoice-items__header--desktop">
                                <th>{{ trans('translations.description') }}</th>
                                <th class="invoice-items__quantity right aligned">{{ trans('translations.quantity') }}</th>
                                <th class="invoice-items__price right aligned">{{ trans('translations.price') }} ({{ trans('translations.ticker.btc') }}) </th>
                                <th class="invoice-items__amount right aligned">{{ trans('translations.amount') }}</th>
                            </tr>
                            <tr class="invoice-items__header--mobile pb-0">
                                <th colspan="4">{{ trans('translations.items_services') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($invoice->items->count())
                                @php ($amount = 0)
                                @foreach ($invoice->items as $item)
                                    @php ($amount = bcadd($amount,bcmul($item->quantity,$item->price_in_satoshi)))
                                    <tr class="invoice-item">
                                        <td data-label="{{ trans('translations.description') }}">
                                            <label>{{ trans('translations.description') }}</label>
                                            {{ $item->description }}
                                        </td>
                                        <td data-label="{{ trans('translations.quantity') }}" class="right aligned">
                                            <label>{{ trans('translations.quantity') }}</label>
                                            {{ $item->quantity }}
                                        </td>
                                        <td data-label="{{ trans('translations.price') }}" class="right aligned">
                                        <label>{{ trans('translations.price') }} ({{ trans('translations.ticker.btc') }})</label>
                                            {{ format_number($item->priceInBtc) }}
                                        </td>
                                        <td data-label="{{ trans('translations.amount') }}" class="right aligned">
                                            <label>{{ trans('translations.amount') }} </label>
                                            {{ format_number(compute_amount($item->price_in_satoshi, $item->quantity)) }}
                                        </td>
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
                            <div><strong>{{ trans('translations.subtotal') }}</strong></div>
                            <div><strong>{{ format_number(to_btc((string)$amount)) }}</strong></div>
                        </div>
                        <div class="invoice-summary__row invoice-summary__total">
                            <div><strong>{{ trans('translations.total') }}</strong></div>
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
                        <label for="btcAddress">{{ trans('translations.btc_address') }}</label>
                        <a id="btcAddress" href="https://chain.so/address/BTC/{{ $invoice->btc_address }}" target="_blank" class="d-block break-word" rel="noreferrer">{{ $invoice->btc_address }}</a>
                        <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(146)->generate($invoice->btc_address)) }} ">
                    </div>
                </div>
                <div class="sixteen wide mobile eight width tablet eight wide computer column">
                    @if ($invoice->notes)
                        <label for="notes">{{ trans('translations.notes') }}</label>
                        <p>{{ $invoice->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="ads__mobile">
        <a href="https://connollysekai.com/" target="_blank">
            <img class="raise" src="{{ asset('images/ads/320x100.jpg') }}" alt="Ad Space">
        </a>
    </div>
    <converter class="my-2"></converter>
    <div class="invoice-actions-wrap mt-2">
        <div class="language-switcher">
            <div class="ui selection dropdown">
                <input type="hidden" name="language" value="{{ \App::getLocale() }}">
                <i class="dropdown icon"></i>
                <div class="default text">English</div>
                <div class="menu">
                        <div class="item" data-value="en">English</div>
                        <div class="item" data-value="es">Español</div>
                        <div class="item" data-value="pt">Português</div>
                        <div class="item" data-value="fr">Français</div>
                        <div class="item" data-value="zh-CN">中文（简体)</div>
                        <div class="item" data-value="zh-TW">中文（繁體)</div>
                        <!-- <div class="item" data-value="ja">{{ trans('translations.japanese') }}</div>
                        <div class="item" data-value="ko">{{ trans('translations.korean') }}</div> -->
                </div>
            </div>
        </div>  
        <div class="ui item invoice-actions">   
            <button type="button" id="converterBtn" class="ui small button button--rounded mr-1"><i class="calculator icon"></i> <span>{{ trans('translations.hide_converter') }}</span></button>
            <button class="ui tiny negative button button--rounded"><i class="file pdf outline icon"></i> <a href="{{ route('invoice.downloadPDF',['invoice' => $invoice]) }}">{{ trans('translations.download_pdf') }}</a></button>
        </div>
    </div>
@endsection

@section('page', 'invoice_view')