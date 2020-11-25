@extends('app')
@section('title', 'Users')

@section('content')
<div class="card">
  <h5 class="card-header">Users</h5>
  <div class="card-body">
    <form action method="GET">
      <div class="row mb-3 justify-content-between">
        <div class="col-lg-5">
          <input type="text" class="form-control" name="query" value="{{ app('request')->input('query') }}" placeholder="Search by name...">
        </div>
        <div class="col">
          <button type="submit" class="btn btn-primary">Search<span class="oi oi-magnifying-glass ml-2"></span></button>
        </div>
        <div class="col">
          <a href="/register" class="btn btn-primary">Create user<span class="oi oi-plus ml-2"></span></a>
        </div>
      </div>
    </form>

    {{-- TODO: make mobile responsive --}}
    <table class="table table-responsive-lg">
      <thead>
        <tr>
          @foreach(['#', 'Name', 'Email', 'Role', 'Created at'] as $column)
          <th scope="col-lg">{{ $column }}</th>
          @endforeach
        </tr>
      </thead>

      <tbody>
        @foreach($users as $user) @if($user->email == 'matrix@uwcisak.jp') @continue @endif
        <tr>
          <th scope="row">{{ 20 * ($users->currentPage() - 1) + $loop->iteration }}</th>
          <td>
            <a href="/users/{{ $user->id }}">
              <img src="{{ $user->profile_photo() }}" alt="Profile photo" class="mr-2 rounded" height="50" width="40">{{ $user->name }}
            </a>
          </td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->role }}</td>
          <td>{{ date("d-m-Y H:i", strtotime($user->created_at)) }}</td>
          {{-- IDEA: show action icons only when hovering over the row --}}
          <td>
            <a href="/users/{{ $user->id }}/edit" class="btn btn-warning"><span class="oi oi-pencil"></span></a>
          </td>
          <td>
            <form action="/users/{{ $user->id }}" method="POST">
              {{-- TODO: popup confirmation modal --}}
              @csrf
              @method('DELETE')
              <button class="btn btn-danger" type="submit"><span class="oi oi-trash"></span></button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{-- TODO: use $users->total() =< 20 (test its output on a second page) --}}
    @if($users->links())
    <div class="row mt-5">
      <div class="col d-flex justify-content-center">{{ $users->links() }}</div>
    </div>
    @endif
  </div>
</div>
@endsection
