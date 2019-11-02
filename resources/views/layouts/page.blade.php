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
        </div>
        <input type="hidden" id="page" value="@yield('page')"> 
        <script src="{{ route('locale.localizeForJs') }}"></script>
        @include('partials.scripts')
    </body>
</html>
