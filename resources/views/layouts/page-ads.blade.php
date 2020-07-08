<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('partials.head')
    <body>
        <div id="app">
            <header class="site-header raise">
                <div class="ui container vertically padded grid">
                    <div class="sixteen wide column centered">
                        @include('partials.nav')
                    </div>
                </div>   
            </header>
            <main class="site-content py-2">
                <div class="invoice__counter text-center"><strong>{{ \App\Invoice::all()->count() }}</strong> {{ trans('translations.btc_invoices_created') }}</div>
                <div class="ui container vertically padded grid">
                    <div class="row pt-0">
                        <div class="sixteen wide mobile sixteen wide tablet twelve wide computer column">
                            @yield('content')
                        </div>
                        <div class="sixteen wide mobile sixteen wide tablet four wide computer column">
                            <div class="ads__side  pt-2">
                                <a href="https://connollysekai.com/" target="_blank">
                                    <img class="raise" src="{{ asset('images/ads/160x600.jpg') }}" alt="Ad Space">
                                </a>
                            </div>
                        </div>
                    </div> 
                </div>
            </main>
            <footer class="text-center pt-2 pb-2 raise">
                <p class="mb-0"><strong>CONNOLLYSEKAI LIMITED</strong></p>
                <p class="mb-0"><small>11-12 Tak Hing Street, Rightful Centre #1902-1904</small></p>
                <p class="mb-0"><small>Kowloon, Hong Kong</small></p>
                <a href="{{ route('advertise.index') }}" class="mb-0" target="_blank"><small>{{ trans('translations.advertise_with_us') }}</small></a>
            </footer>
        </div>
        <input type="hidden" id="page" value="@yield('page')"> 
        <script src="{{ route('locale.localizeForJs') }}"></script>
        @include('partials.scripts')
    </body>
</html>
