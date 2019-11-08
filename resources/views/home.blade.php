@extends('layouts.page')

@section('title', trans('translations.home'))

@section('content')

<form action="{{ route('invoice.store') }}" method="post" class="ui form" ref="form" @submit.prevent="handleSubmit()" @keydown="invoice.form.errors.clear($event.target.name)" v-cloak>
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
                                <h2>{{ trans('translations.invoice') }}</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="sixteen wide mobile eight width tablet eight wide computer column">
                                <div class="field" :class="invoice.form.errors.has('business_name') ? 'error':''">
                                    <label for="businessName">{{ trans('translations.business_name') }}</label>
                                    <input type="text" id="businessName" name="business_name" placeholder="{{ trans('translations.business_name_placeholder') }}" v-model="invoice.form.business_name" data-scroll-anchor="business_name">
                                    <div v-if="invoice.form.errors.has('business_name')" class="ui mini basic negative pointing prompt label visible">@{{ invoice.form.errors.first('business_name') }}</div>
                                </div>
                                <div class="field" :class="invoice.form.errors.has('business_email') ? 'error':''">
                                    <label for="businessEmail">{{ trans('translations.business_email') }}</label>
                                    <input type="text" id="businessEmail" name="business_email" placeholder="{{ trans('translations.business_email_placeholder') }}" v-model="invoice.form.business_email" data-scroll-anchor="business_email">
                                    <div v-if="invoice.form.errors.has('business_email')" class="ui mini basic negative pointing prompt label visible">@{{ invoice.form.errors.first('business_email') }}</div>
                                </div>
                                <div class="field" :class="(invoice.form.errors.has('business_calling_code') || invoice.form.errors.has('business_mobile_number')) ? 'error':''">
                                    <label for="businessMobileNumber">{{ trans('translations.mobile_number') }} <small>({{ trans('translations.optional') }})</small></label>
                                    <div class="d-flex">
                                        <div class="invoice-view__calling-code mr-1">
                                            <imask-input v-model="invoice.form.business_calling_code" placeholder="{{ trans('translations.calling_code_placeholder') }}" name="business_calling_code" :mask="'+num'" :blocks="{ num: { mask: Number}}" :lazy="true" data-scroll-anchor="business_calling_code" aria-label="Business Calling Code"/>
                                        </div>
                                        <imask-input id="businessMobileNumber" v-model="invoice.form.business_mobile_number" placeholder="{{ trans('translations.mobile_number_placeholder') }}" name="business_mobile_number" :mask="/^(\d+[-]{0,1})*$/" data-scroll-anchor="business_mobile_number" />
                                    </div>
                                    <div v-if="invoice.form.errors.has('business_mobile_number')" class="ui mini basic negative pointing prompt label visible">@{{ invoice.form.errors.first('business_mobile_number') }}</div>
                                    <div v-if="invoice.form.errors.has('business_calling_code')" class="ui mini basic negative pointing prompt label visible">@{{ invoice.form.errors.first('business_calling_code') }}</div>
                                </div>
                                <div class="field" :class="invoice.form.errors.has('btc_address') ? 'error':''">
                                    <label for="btcAddress">{{ trans('translations.btc_address') }}</label>
                                    <input type="text" id="btcAddress" name="btc_address" placeholder="{{ trans('translations.btc_address_placeholder') }}" v-model="invoice.form.btc_address" data-scroll-anchor="btc_address">
                                    <div v-if="invoice.form.errors.has('btc_address')" class="ui mini basic negative pointing prompt label visible">@{{ invoice.form.errors.first('btc_address') }}</div>
                                </div>
                                <div class="field">
                                    <label for="btcAddressConfirmation">{{ trans('translations.confirm_btc_address') }}</label>
                                    <input type="text" id="btcAddressConfirmation" name="btc_address_confirmation" placeholder="{{ trans('translations.btc_address_placeholder') }}" v-model="invoice.form.btc_address_confirmation">
                                </div>
                            </div>
                            <div class="sixteen wide mobile eight width tablet eight wide computer column">
                                <div class="field" :class="invoice.form.errors.has('client_name') ? 'error':''">
                                    <label for="clientName">{{ trans('translations.client_name') }}</label>
                                    <input type="text" id="clientName" name="client_name" placeholder="{{ trans('translations.client_name_placeholder') }}" v-model="invoice.form.client_name" data-scroll-anchor="client_name">
                                    <div v-if="invoice.form.errors.has('client_name')" class="ui mini basic negative pointing prompt label visible">@{{ invoice.form.errors.first('client_name') }}</div>
                                </div>
                                <div class="field" :class="invoice.form.errors.has('client_email') ? 'error':''">
                                    <label for="clientEmail">{{ trans('translations.client_email') }}</label>
                                    <input type="text" id="clientEmail" name="client_email" placeholder="{{ trans('translations.client_email_placeholder') }}"  v-model="invoice.form.client_email" data-scroll-anchor="client_email">
                                    <div v-if="invoice.form.errors.has('client_email')" class="ui mini basic negative pointing prompt label visible">@{{ invoice.form.errors.first('client_email') }}</div>
                                </div>
                                <div class="field" :class="(invoice.form.errors.has('client_calling_code') || invoice.form.errors.has('client_mobile_number')) ? 'error':''">
                                    <label for="clientMobileNumber">{{ trans('translations.mobile_number') }} <small>({{ trans('translations.optional') }})</small></label>
                                    <div class="d-flex">
                                        <div class="invoice-view__calling-code mr-1">
                                            <imask-input v-model="invoice.form.client_calling_code" placeholder="{{ trans('translations.calling_code_placeholder') }}" name="client_calling_code" :mask="'+num'" :blocks="{ num: { mask: Number}}" :lazy="true" data-scroll-anchor="client_calling_code" aria-label="Client Calling Code"/>
                                        </div>
                                        <imask-input id="clientMobileNumber" v-model="invoice.form.client_mobile_number" placeholder="{{ trans('translations.mobile_number_placeholder') }}" name="client_mobile_number" :mask="/^(\d+[-]{0,1})*$/" data-scroll-anchor="client_mobile_number"/>
                                    </div>
                                    <div v-if="invoice.form.errors.has('client_mobile_number')" class="ui mini basic negative pointing prompt label visible">@{{ invoice.form.errors.first('client_mobile_number') }}</div>
                                    <div v-if="invoice.form.errors.has('client_calling_code')" class="ui mini basic negative pointing prompt label visible">@{{ invoice.form.errors.first('client_calling_code') }}</div>     
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
                                        <tr>
                                            <th>{{ trans('translations.description') }}</th>
                                            <th class="invoice-items__quantity right aligned">{{ trans('translations.quantity') }}</th>
                                            <th class="invoice-items__price right aligned">{{ trans('translations.price') }}</th>
                                            <th class="invoice-items__amount right aligned">{{ trans('translations.amount') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="invoice-item" v-for="(item,key) in invoice.form.items" :key="`item-${key}`">
                                            <td data-label="Description">
                                                <div class="field mb-0" :class="invoice.form.errors.has(`items.${key}.description`) ? 'error':''">
                                                    <input type="text" v-model="invoice.form.items[key].description" :name="`items.${key}.description`" :data-scroll-anchor="`items.${key}.description`" :aria-label="`Item Description ${key}`">
                                                </div>
                                            </td>
                                            <td data-label="Quantity" class="right aligned">
                                                <div class="field mb-0" :class="invoice.form.errors.has(`items.${key}.quantity`) ? 'error':''">
                                                    <imask-input class="text-right" :name="`items.${key}.quantity`" v-model="invoice.form.items[key].quantity" :mask="Number" @change="updateAmount(key)" :data-scroll-anchor="`items.${key}.quantity`" :aria-label="`Item Quantity ${key}`"/>
                                                </div>
                                            </td>
                                            <td data-label="Price" class="right aligned">
                                                <div class="field mb-0" :class="invoice.form.errors.has(`items.${key}.price_in_satoshi`) ? 'error':''">
                                                    <imask-input class="text-right" :name="`items.${key}.price_in_satoshi`" v-model="invoice.form.items[key].price" :mask="/^(\d+)?([.]?\d{0,8})$/" @change="updateAmount(key)" :data-scroll-anchor="`items.${key}.price`" :aria-label="`Item Price ${key}`"/>
                                                </div>
                                            </td>
                                            <td v-cloak data-label="Amount" class="right aligned"><div class="invoice-item__amount">@{{ item.amount }} <i class="times icon invoice-item__delete-btn" @click="deleteItem(key)" v-show="invoice.form.items.length != 1"></i></div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row pt-0">
                            <div class="sixteen wide mobile eight width tablet eight wide computer column">
                                <button type="button" class="ui mini basic primary button button--rounded mr-1" @click="addItem()"><i class="plus icon"></i>{{ trans('translations.add_item') }}</button>
                            </div>
                            <div class="sixteen wide mobile eight width tablet eight wide computer column">
                                <div class="invoice-summary">
                                    <div class="invoice-summary__row">
                                        <div><span>{{ trans('translations.subtotal') }}</span></div>
                                        <div v-cloak><strong>@{{ invoice.subtotal }}</strong></div>
                                    </div>
                                    <div class="invoice-summary__row invoice-summary__total">
                                        <div><span>{{ trans('translations.total') }}</span></div>
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
                                    <label for="notes">{{ trans('translations.notes') }} <small>({{ trans('translations.optional') }})</small></label>
                                    <textarea id="notes" name="notes" rows="4" v-model="invoice.form.notes"></textarea>
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
                <div class="invoice-actions-wrap">
                    <div class="language-switcher">
                        <div class="ui selection dropdown">
                            <input type="hidden" name="language" value="{{ session('locale', 'en') }}">
                            <i class="dropdown icon"></i>
                            <div class="default text">English</div>
                            <div class="menu">
                                <div class="item" data-value="en">{{ trans('translations.english') }}</div>
                                <div class="item" data-value="zh-Hans">{{ trans('translations.chinese_simplified') }}</div>
                                <div class="item" data-value="zh-Hant">{{ trans('translations.chinese_traditional') }}</div>
                                <div class="item" data-value="ja">{{ trans('translations.japanese') }}</div>
                                <div class="item" data-value="ko">{{ trans('translations.korean') }}</div>
                                <div class="item" data-value="es">{{ trans('translations.spanish') }}</div>
                                <div class="item" data-value="fr">{{ trans('translations.french') }}</div>
                            </div>
                        </div>
                    </div>  
                    <div class="ui item invoice-actions">      
                        <button type="button" id="converterBtn" class="ui small primary button button--rounded mr-1"><i class="calculator icon"></i> <span>{{ trans('translations.show_converter') }}</span></button>
                        <button type="submit" id="sendInvoiceBtn" class="ui small secondary button button--rounded"><i class="paper plane outline icon"></i> {{ trans('translations.create_invoice') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('page', 'invoice_form')