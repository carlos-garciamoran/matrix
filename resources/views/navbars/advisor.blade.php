<li class="nav-item">
  <a class="nav-link" href="/advisory">Advisory</a>
</li>

<li class="nav-item">
  <a class="nav-link" href="/absences/create">Absence request</a>
</li> 


@if(app('advisor')->duty)
<li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Residential Team</a>
  <div class="dropdown-menu">
    @foreach(range(1,4) as $residence)
    @if($residence==1)
    @foreach([10, 11, 14, 15] as $house)
    <a class="dropdown-item" href="/students?residence={{ $residence }}&house={{ $house }}">R{{ $residence }}-{{ $house }}</a>
    @endforeach

    @elseif($residence==2||$residence==3)
    @foreach([10, 12, 14] as $house)
    <a class="dropdown-item" href="/students?residence={{ $residence }}&house={{ $house }}">R{{ $residence }}-{{ $house }}</a>
    @endforeach

    @else
    @foreach([10, 20] as $house)
    <a class="dropdown-item" href="/students?residence={{ $residence }}&house={{ $house }}">R{{ $residence }}-{{ $house }}</a>
    @endforeach

    @endif
    <div class="dropdown-divider"></div>
    @endforeach
    
    <a class="dropdown-item" href="/students?off-campus">Off-campus</a>
    <a class="dropdown-item" href="/students">All students</a>
  </div>
</li>
@endif
