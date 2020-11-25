@extends('app')
@section('title', 'Edit user')

@section('content')
<div class="row justify-content-center">
  <div class="col">
    <div class="card">
      <h5 class="card-header">Edit user</h5>
      <div class="card-body">
        <form action="/users/{{ $user->id }}" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
        @method('PATCH')
        @include('users.form', ['action' => 'edit'])
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="/js/bootstrap-form.js"></script>
<script>
  $('#profile_photo').on('change',function(){
    var fileName = $(this).val().substr(12);
    $(this).next('.custom-file-label').html(fileName);
  });
</script>
@endsection
