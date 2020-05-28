<header class="bg-dark mb-3">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="{{route('pages.home')}}">Soccermarkt</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample09">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item {{ Request::path() == '/' ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('pages.home')}}">Home</a>
                    </li>
                    <li class="nav-item {{ Request::path() == 'leagues' ? 'active' : '' }}">
                        <a class="nav-link" href="{{route('pages.leagues')}}">Leagues</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>