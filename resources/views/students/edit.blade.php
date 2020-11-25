@extends('app')
@section('title', 'Edit student')

@section('content')
<div class="row justify-content-center">
  <div class="col">
    <div class="card">
      <h5 class="card-header">Edit student</h5>
      <div class="card-body">
        <form class="needs-validation" method="POST" action="/students/{{ $student->user_id }}" novalidate>
        @method('PATCH')
        @include('students.form', ['action' => 'edit'])
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
{{-- TODO: download files and store them locally --}}
<script src="/js/bootstrap-form.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

<script>$(".chosen-select").chosen({max_selected_options: 2});</script>
@endsection
