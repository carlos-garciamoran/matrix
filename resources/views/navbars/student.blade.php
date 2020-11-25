<li class="nav-item">
    {{-- TODO: cache me & update me on sign out/in  --}}
  @if(app('student')->isOnCampus()) <a class="nav-link" href="/sign-out">Sign Out</a>
  @else <a class="nav-link" href="/sign-in">Sign In</a>
  @endif
</li>
