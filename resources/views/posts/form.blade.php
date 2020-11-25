@csrf
<div class="row">
  <div class="col-lg-3 form-group">
    <div id="title-field">
      <label for="title">Title</label>
      <input class="form-control" type="text" minlength="3" maxlength="70" id="date" name="title" value="{{ old('title', $post->title) }}" required autofocus>
      <div class="invalid-feedback">Make sure your title makes sense.</div>
    </div>

    {{-- TODO: validate select @ front-end (at least 1 value checked) --}}
    <div class="mt-3" id="audience-id">
      <label>Audience</label>
      <div class="row">
        <div class="col-lg">
        @foreach(['G10', 'G11'] as $audience)
          <div class="form-check custom-control custom-checkbox">
            <input class="form-check-input" type="checkbox" id="{{ $audience }}" name="audience[]" value="{{ $audience }}">
            <label class="form-check-label" for="{{ $audience }}">{{ $audience }}</label>
          </div>
        @endforeach
        </div>

        <div class="col-lg">
        @foreach(['G12', 'Faculty'] as $audience)
          <div class="form-check custom-control custom-checkbox">
            <input class="form-check-input" type="checkbox" id="{{ $audience }}" name="audience[]" value="{{ $audience == 'Faculty' ? strtolower($audience) : $audience }}">
            <label class="form-check-label" for="{{ $audience }}">{{ $audience }}</label>
          </div>
        @endforeach
        </div>
        <div class="col-lg">
        @foreach(['Staff'] as $audience)
          <div class="form-check custom-control custom-checkbox">
            <input class="form-check-input" type="checkbox" id="{{ $audience }}" name="audience[]" value="{{ $audience == 'Staff' ? strtolower($audience) : '' }}">
            <label class="form-check-label" for="{{ $audience }}">{{ $audience }}</label>
          </div>
        @endforeach
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-2 form-group">
    <div id="date-field">
      <label for="date">Date</label>
      <input class="form-control" type="date" value="{{ old('publish_date', $post->publish_date ?? date('Y-m-d')) }}" id="date" name="publish_date" required>
      <div class="invalid-feedback">Make sure you select a date.</div>
    </div>

    <div class="mt-3" id="type-field">
      <label>Type</label>
      @foreach(['Announcement', 'Reminder'] as $item)
      <div class="form-check">
        <input class="form-check-input" type="radio" name="type" id="{{ $item }}" value="{{ strtolower($item) }}" required{{ strtolower($item) == old('type', $post->type) ? ' checked' : '' }}>
        <label class="form-check-label" for="{{ $item }}">{{ $item }}</label>
        @if($loop->last) <div class="invalid-feedback">Make sure you select a post type.</div> @endif
      </div>
      @endforeach
    </div>
  </div>

  <div class="col-lg-7 form-group">
    <label for="body">Description</label>
    <textarea class="form-control" minlength="5" maxlength="2000" rows="5" placeholder="Provide a short blurb..." id="body" name="body">{{ old('body', $post->body) }}</textarea>  
 </div>
</div>
<button class="btn btn-primary btn-block" type="submit">Submit</button>

@section('scripts')
<script src="/js/bootstrap-form.js"></script>

<script>
  $('#Everyone').change(function() {
    if ($('#Everyone').is(":checked")) {
      var boxes = ['G10', 'G11', 'G12', 'Faculty', 'Staff'];

      boxes.forEach(box => $('#' + box).prop('checked', true));
    }
  });
</script>
@endsection
