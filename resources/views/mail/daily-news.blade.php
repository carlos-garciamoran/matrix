<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://matrix.uwcisak.jp/css/app.css">
  </head>

  <body>
    <div class="container" style="background-color: white">
      @foreach(['announcements' => $announcements, 'reminders' => $reminders] as $category => $items)
      <div class="row{{ $loop->first ? '' : ' mt-5' }}">
        <div class="col">
          <h1 class="display-5 text-center">{{ ucfirst($category) }}</h1>
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
              </h6>
              {{-- TODO: refactor to mitigate potential XSS vuln. --}}
              @php($body = preg_replace('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', '<a href="$0">$0</a>', e($item->body)))
              <p class="card-text">{!! nl2br($body) !!}</p>
            </div>
          </div>
        </div>
      </div>
      @endforeach
      @endif
      @endforeach

      <div class="row mt-4">
        <div class="col">
          <a href="{{ url('posts/create') }}" class="btn btn-primary btn-block">Create new post</a>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col">
          <div class="alert alert-info d-flex justify-content-center">
            <a href="https://forms.gle/x1rvEKGSajcPswSN7">Assembly Activity Form</a>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col">
          <div class="alert alert-info d-flex justify-content-center">
            <a href="https://landbot.io/u/H-297960-IZA9CKEREJX6CMTD/index.html">Link to ASAMU</a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
