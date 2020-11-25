<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" href="/images/apple-touch-icon.png">

    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/vendor/open-iconic/font/css/open-iconic-bootstrap.min.css">

    <title>@yield('title') — {{ config('app.name') }}</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="/">
        <img src="/images/logo.png" alt="{{ config('app.name') }}">
      </a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse" id="navbar">
        @auth
        <ul class="navbar-nav mr-auto">
          <li class="nav-item"><a class="nav-link" href="/posts">News dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="/posts?my-posts">My posts</a></li>
          @if($user->moderator) <li class="nav-item"><a class="nav-link" href="/posts?all">Moderation dashboard</a></li> @endif
          @if($user->isStudent()) @include('navbars.student')
          @elseif($user->isAdvisor()) @include('navbars.advisor')
          @endif
          @if($user->admin)
          <li class="nav-item"><a class="nav-link" href="/users">Users</a></li>
          <li class="nav-item"><a class="nav-link" href="/absences">Absences panel</a></li> 
          @endif
        </ul>
        @endauth
        <ul class="navbar-nav ml-auto">
          @guest
          <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
          </li>
          @else
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
              <span class="caret">{{ $user->student->nickname ?? $user->first_name }}</span>
              <img src="{{ $user->profile_photo() }}" alt="Profile photo" class="mr-2 rounded" height="45" width="45">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="/profile">Profile</a>
              <a class="dropdown-item" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
              <form id="logout-form" action="/logout" method="POST" style="display: none;">@csrf</form>
            </div>
          </li>
          @endguest
        </ul>
      </div>
    </nav>

    <div class="container-fluid">
      @yield('content')
    </div>

    <script src="/js/manifest.js"></script>
    <script src="/js/vendor.js"></script>
    <script src="/js/app.js"></script>
    @yield('scripts')
  </body>
</html>
