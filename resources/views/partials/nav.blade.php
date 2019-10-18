<nav class="site-header__nav row centered">
    <div class="sixteen wide mobile sixteen wide tablet twelve wide computer column">
        <a href="#" class="site-logo active">
            @include('partials.logo')
        </a>
        <div class="site-search active">
            <div class="site-search__form">
                <div class="ui action fluid input">
                    <input type="text" placeholder="Contract ID" aria-label="Contract ID">
                    <button class="ui primary button">Search</button>
                </div>
            </div>
            <div class="site-search__icon">
                <i id="searchOpenBtn" class="large search icon"></i>
            </div>
        </div>
        <div class="site-search__mobile">
            <div class="site-search__form">
                <div class="ui action fluid input">
                    <input type="text" placeholder="Contract ID" aria-label="Contract ID">
                    <button class="ui primary button">Search</button>
                </div>
            </div>
            <div class="site-search__icon text-center">
                <i id="searchCloseBtn" class="large times icon"></i>
            </div>
        </div>
    </div>
</nav>