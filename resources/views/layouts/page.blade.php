<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('partials.head')
    <body>
        <div id="app">
            <header class="site-header raise">
                <div class="ui container vertically padded grid">
                    @include('partials.nav')
                </div>   
            </header>
            <main class="site-content py-2">
                @yield('content')
                <div class="ui mini modal">
                    <div class="header">Choose Currency</div>
                    <div class="content">
                        <div class="ui fluid selection dropdown">
                            <i class="dropdown icon"></i>
                            <div class="text">AUD</div>
                            <div class="menu">
                                <div class="item">USD</div>
                                <div class="item">BTC</div>
                                <div class="item">AUD</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="ui tiny primary button button--rounded mt-1">Convert</button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        @include('partials.scripts')
    </body>
</html>
