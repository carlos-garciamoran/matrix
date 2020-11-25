@extends('app')
@section('title', $title)

@section('content')
<div class="card">
  <h5 class="card-header">{{ $title }}</h5>
  <div class="card-body">
    @foreach(['announcements' => $announcements, 'reminders' => $reminders] as $category => $items)
    <div class="row{{ $loop->first ? '' : ' mt-5' }}">
      <div class="col">
        <h1 class="display-4 text-center">{{ ucfirst($category) }}</h1>
      </div>
    </div>
    @if($items->isEmpty())
    <div class="row mt-2">
      <div class="col">
        <div class="alert alert-info d-flex justify-content-center mt-3">No {{ $category }} for today!</div>
      </div>
    </div>
    @else
    @foreach($items as $item)
    <div class="row mt-2">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">{{ $item->title }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">
              <span class="font-italic">By {{ \App\User::find($item->user_id)->name }}</span>
              | For <span class="font-weight-bold">{{ $item->audience }}</span>
              @if($page != 'standard')
              | Scheduled for: <span class="font-weight-light" style="text-decoration: underline">{{ $item->publish_date }}</span>
              @endif
            </h6>
            {{-- TODO: refactor to mitigate potential XSS vuln. --}}
            @php($body = preg_replace('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', '<a href="$0">$0</a>', e($item->body)))
            <p class="card-text">{!! nl2br($body) !!}</p>
            @if($page == 'my-posts')
            <div class="d-flex justify-content-around border rounded-pill">
              <a href="/posts/{{ $item->id }}/edit" class="btn btn-warning my-2">Edit<span class="oi oi-pencil ml-2"></span></a>
              <form action="/posts/{{ $item->id }}" method="POST">
                @csrf  {{-- TODO: popup confirmation modal --}}
                @method('DELETE')
                <button class="btn btn-danger float-right my-2" type="submit">Delete<span class="oi oi-trash ml-2"></span></button>
              </form>
            </div>
            @endif

            @if($page == 'moderator')
            <form action="/posts/{{ $item->id }}" method="POST">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger mt-1 float-right" type="submit">Delete<span class="oi oi-trash ml-2"></span></button>
            </form>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
    @endif
    @endforeach

    <div class="row mt-4">
      <div class="col">
        <a href="/posts/create" class="btn btn-primary btn-block">Create new post<span class="oi oi-plus ml-2"></span></a>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col">
        <div class="alert alert-info d-flex justify-content-center">
          <a href="https://forms.gle/x1rvEKGSajcPswSN7">Assembly Activity Form</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row mt-3">
  <script src="https://static.landbot.io/landbot-widget/landbot-widget-1.0.0.js"></script>

  <div id="myLandbot" style="width: 100%; height: 500px"></div>
  <script>
    var myLandbot = new LandbotFrameWidget({
      container: '#myLandbot',
      index: 'https://landbot.io/u/H-297960-IZA9CKEREJX6CMTD/index.html',
    });
  </script>
</div>
@endsection

@section('scripts')
<script src="/js/bootstrap-form.js"></script>
@endsection
