@extends('app')
@section('title', 'Create user')

@section('content')
<div class="row justify-content-center">
  <div class="col">
    <div class="card">
      <h5 class="card-header">Create user</h5>
      <div class="card-body">
        <form class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
        @include('users.form', ['action' => 'registration'])
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
