<nav class="navbar navbar-expand-lg top-menu" role="navigation" aria-label="main navigation">
    <a class="navbar-brand logo" href="{{ route('dashboard.show') }}">
            <svg height="24" width="24" viewBox="0 0 100 100">
                <path fill="#1389d2" d="M50.3,1.2C23.6,1.2,1.9,22.9,1.9,49.7c0,26.7,21.7,48.4,48.4,48.4c26.7,0,48.4-21.7,48.4-48.4
          C98.7,22.9,77.1,1.2,50.3,1.2z M50.3,88.2c-21.3,0-38.5-17.3-38.5-38.5c0-21.3,17.3-38.5,38.5-38.5c21.3,0,38.5,17.3,38.5,38.5
          C88.9,70.9,71.6,88.2,50.3,88.2z"></path>
                <path fill="#1389d2" d="M62.9,90.7l0.5-45.2l1.3-0.5l0.5-1.7l-14.8-3.7l-0.7,2.4c-0.8,0-2,0-3.4,0c0-6.6,0-12.3,0-12.3l0.6-0.7
          h18.8v-3.6c0,0-6.4-8.5-18-8.5c-12,0-11.8,8.8-11.8,9.7c0,0,0,6.7,0,15.3c-1.5,0-4.4,1.1-4.4,5.2c0,3.8,2,4.8,1.7,8.4
          c-0.4,4.2,0.8,4.9,2.7,5.4c0,0.9,0,1.6,0,2.5h-2.2v7.1h2.2c0,4.9,0,6.7,0,7.2c0,3.4,1.4,5.4,5,5.4c3.7,0,4.9-1.8,4.9-5.5
          c0-0.3,0,0.2,0-0.8c1.4,0,4,1.6,4,3.9l0,1.8c0,3.5,0,4.6,0.1,8.2H62.9z M49.8,61.1c0,3.6,0,7.5,0.1,11.6h-4c0-0.7,0-1.4,0-2.2h2
          v-7.1h-2c0-0.8,0-1.5,0-2.3C47.1,61.1,48.8,61.1,49.8,61.1z"></path>
            </svg>
    </a>
    <span class="logo-text">Solder <small>{{ config('app.version') }}</small></span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownModpack" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Modpacks
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownModpack">
                    @foreach($modpacks as $modpackItem)
                        <a class="dropdown-item {{ isset($modpack) && $modpack->id == $modpackItem->id ? 'active' : '' }}" href="{{ route('modpacks.show', ['modpack' => $modpackItem->slug]) }}">
                            {{ $modpackItem->name }}
                        </a>
                    @endforeach
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('dashboard.show') }}">
                        Create
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('library.list') }}">Library</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('settings.api.show') }}">Settings</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ Auth()->user()->username }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownUser">
                  <a class="dropdown-item" href="javascript:{}" onclick="document.getElementById('logout').submit(); return false;">Log Out</a>
                  <form id="logout" action="{{ route('auth.logout') }}" method="POST">
                    {{ csrf_field() }}
                  </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
