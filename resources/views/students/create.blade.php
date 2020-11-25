@extends('app')
@section('title', 'Register student')

@section('content')
<div class="row justify-content-center">
  <div class="col">
    <div class="card">
      <h5 class="card-header">Register student</h5>
      <div class="card-body">
        <form class="needs-validation" method="POST" enctype="multipart/form-data" action="/students" novalidate>
        @include('students.form', ['action' => 'registration'])
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
{{-- TODO: download files to store them locally --}}
<script src="/js/bootstrap-form.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

<script>
  $(".chosen-select").chosen({max_selected_options: 2});

  $('#official_photo').on('change',function(){
    var fileName = $(this).val().substr(12);
    $(this).next('.custom-file-label').html(fileName);
  });
</script>
@endsection
