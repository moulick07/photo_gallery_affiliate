<li class="nav-item">

    {{-- Search toggle button --}}
    <a class="nav-link" data-widget="navbar-search" href="" role="button">
        <i class="fas fa-search"></i>
    </a>

    {{-- Search bar --}}
    <div class="navbar-search-block">
        <form class="form-inline" action={{ route('search.user') }} method='get'>
            {{ csrf_field() }}

            
            <div class="input-group">
            {{-- Search input --}}
                <input class="form-control form-control-navbar" type="search" name="search"
                    placeholder="{{ $item['text'] }}"
                    aria-label="{{ $item['text'] }}"></div>
                {{-- Search buttons --}}
                <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-navbar" type="submit" data-widget="navbar-search">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

            </div>
        </form>
    </div>

</li>
