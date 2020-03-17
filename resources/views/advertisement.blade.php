@extends('layouts.page')

@section('title', trans('translations.advertise_with_us'))

@section('content')

    @if (session('not_found'))
        @include('partials.notification')
    @endif
    <div class="advertisement raise rounded my-2 text-center">
        <h2>{{ trans('translations.advertise_with_us') }}</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum recusandae sint officia, quam non rem eum, asperiores reprehenderit accusamus explicabo expedita molestias dicta consequatur impedit quisquam autem amet, perferendis dolore.</p>
        <div class="advertisement__desktop mb-2">
            <h4>{{ trans('translations.ad_layout_for') }}</h4>
            <img src="{{ asset('images/ad_layout_desktop.jpg') }}" alt="Desktop Ad Layout ">
        </div>
        <div>
            <div class="pricing">
                <div class="pricing__heading">
                    <span>$30</span>/{{ trans('translations.month') }}
                </div>
                <div class="pricing__body">
                    <p class="mb-1">{{ trans('translations.ad_space_for') }}</p>
                    <p>{{ trans('translations.contact_us') }} <br> <strong>support@sekaipay.com</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="invoice-actions-wrap mt-2">
        <div class="language-switcher">
            <div class="ui selection dropdown">
                <input type="hidden" name="language" value="{{ \App::getLocale() }}">
                <i class="dropdown icon"></i>
                <div class="default text">{{ trans('translations.english') }}</div>
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
    </div>

@endsection

@section('page', 'advertisement')