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
            </main>
            <footer class="text-center pt-2 pb-2 raise">
                <p class="mb-0"><strong>CONNOLLYSEKAI LIMITED</strong></p>
                <p class="mb-0"><small>1-12 Tak Hing Street, Rightful Centre #1902-1904</small></p>
                <p><small>Kowloon, Hong Kong</small></p>
            </footer>
        </div>
        <input type="hidden" id="page" value="@yield('page')"> 
        <script src="{{ route('locale.localizeForJs') }}"></script>
        @include('partials.scripts')
    </body>
</html>
