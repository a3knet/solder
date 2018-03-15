<nav class="navbar navbar-expand-lg navbar-dark bg-primary" role="navigation" aria-label="main navigation">
    <a class="navbar-brand" href="#">
        &nbsp;
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="/library">Library</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/settings/api">Settings</a>
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
