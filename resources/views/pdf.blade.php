<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="base-url" content="{{ URL::to('/') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            html {
                font-size: 16px;
                font-family: 'Muli', sans-serif;
            }

            body {
                background-color: white;
                color: #444444;
                font-size: 16px;
                font-weight: 400;
                line-height: 1.45;
            }

            h1, h2, h3, h4, h5 {
                margin: 2.75rem 0 1rem;
                font-weight: 800;
                line-height: 1.15;
            }

            label {
                display: block;
                font-weight: 800;
                margin-bottom: 0.5rem;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            .block {
                display: block;
            }

            .row {
                margin-bottom: 1rem;
            }

            .row::after {
                content: "";
                clear: both;
                display: table;
            }

            .column {
                float: left;
            }

            .half {
                width: 50%;
            }

            .divider {
                background-color: #E0E1E2;
                content: "";
                display: block;
                height: 1px;
                width: 100%;
            }

            .text-center {
                text-align: center;
            }

            .text-right {
                text-align: right;
            }

            .mt {
                margin-top: 20px;
            }

        
            .invoice__items thead {
                background-color: #5EBAF2;
                color: #ffffff;
            }

            .invoice__items thead tr th,
            .invoice__items tbody tr td {
                padding: 0.78571429em 0.78571429em;
            }

            .invoice__items tbody tr td {
                border-bottom: solid 1px #E0E1E2;
            }

            .invoice__summary td {
                padding: 0.78571429em 0.78571429em;
            }

            .invoice__footer a {
                color: #0597F2;
                text-decoration: none;
            }
            
        </style>
    </head>
    <body>
        <div id="app" class="wrapper">
            
            <div class="invoice">
                <div class="invoice__head">
                    <div class="invoice__title"><h2>Invoice</h2></div>
                    <div class="invoice__info">
                        <div class="row">
                            <div class="column half">
                                <label>Contract ID</label>
                                <span>{{ $invoice->contract_id }}</span>
                            </div>
                            <div class="column half">
                                <label>Invoice Date</label>
                                <span>{{ $invoice->created_at->format('m-d-Y') }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="column half">
                                <label>From</label>
                                <span class="block">{{ $invoice->business_name }}</span>
                                <span class="block">{{ $invoice->business_email }}</span>
                                <span class="block">{{ $invoice->business_mobile_number }}</span>
                            </div>
                            <div class="column half">
                                <label>To</label>
                                <span class="block">{{ $invoice->client_name }}</span>
                                <span class="block">{{ $invoice->client_email }}</span>
                                <span class="block">{{ $invoice->client_mobile_number }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="invoice__body mt">
                    <table class="invoice__items">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th class="text-right">Quantity</th>
                                <th class="text-right">Price</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($invoice->items->count())
                                @php ($amount = 0)
                                @foreach ($invoice->items as $item)
                                    @php ($amount = bcadd($amount,bcmul($item->quantity,$item->price_in_satoshi)))
                                    <tr>
                                        <td>{{ $item->description }}</td>
                                        <td class="text-right">{{ $item->quantity }}</td>
                                        <td class="text-right">{{ format_number($item->priceInBtc) }}</td>
                                        <td class="text-right">{{ format_number(compute_amount($item->price_in_satoshi, $item->quantity)) }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <table>
                        <tr>
                            <td class="half"></td>
                            <td class="half">
                                <table class="invoice__summary">
                                    <tr>
                                        <td>Subtotal</td>
                                        <td class="text-right"><strong>{{ format_number(to_btc((string)$amount)) }}</strong></td>
                                    </tr>
                                    <tr style="background-color:#E0E1E2">
                                        <td>Total</td>
                                        <td class="text-right"><strong>{{ format_number(to_btc((string)$amount)) }}</strong></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="divider mt"></div>
                <div class="invoice__footer mt">
                    <div class="row">
                        <div class="column half">
                            <div class="text-center">
                                <label>BTC Address</label>
                                <a href="https://chain.so/address/BTC/{{ $invoice->btc_address }}" target="_blank" class="block" rel="noreferrer">{{ $invoice->btc_address }}</a>
                                <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(146)->generate($invoice->btc_address)) }} ">
                            </div>
                        </div>
                        <div class="column half">
                            @if ($invoice->notes)
                                <label for="notes">Notes</label>
                                <p>{{ $invoice->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/php">
            if (isset($pdf) && $PAGE_COUNT > 1) {
                $x = (ceil($pdf->get_width()) / 2) - 20;
                $y = ceil($pdf->get_height()) -35;
                $text = "Page {PAGE_NUM}";
                $font = null;
                $size = 10;
                $color = null;
                $word_space = 0.0;  //  default
                $char_space = 0.0;  //  default
                $angle = 0.0;   //  default
                $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            }
        </script>
    </body> 
</html>
