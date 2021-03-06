<nav class="site-header__nav">
    <a href="{{ route('home.index') }}" class="site-logo active">
        @include('partials.logo')
    </a>
    <div class="site-search active">
        <div class="site-search__form">
            <form action="{{ route('invoice.search') }}" method="get" class="ui form">
                <div class="ui action fluid input">
                    <input type="text" name="contract_id" placeholder="{{ trans('translations.contract_id') }}" aria-label="Contract ID" value="{{ request('contract_id') }}">
                    <button class="ui primary button">{{ trans('translations.search') }}</button>
                </div>
            </form>
        </div>
        <div class="site-search__icon">
            <i id="searchOpenBtn" class="large search icon"></i>
        </div>
    </div>
    <div class="site-search__mobile">
        <div class="site-search__form">
            <form action="{{ route('invoice.search') }}" method="get" class="ui form">
                <div class="ui action fluid input">
                    <input type="text" name="contract_id" placeholder="{{ trans('translations.contract_id') }}" aria-label="Contract ID" value="{{ request('contract_id') }}">
                    <button class="ui primary button">{{ trans('translations.search') }}</button>
                </div>
            </form>
        </div>
        <div class="site-search__icon text-center">
            <i id="searchCloseBtn" class="large times icon"></i>
        </div>
    </div>
</nav>