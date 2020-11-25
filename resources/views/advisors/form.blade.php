@csrf
<div class="form-group row">
  <label for="title" class="col-lg-4 col-form-label text-lg-right">Title</label>
  <div class="col-lg-6">
    <select id="title" class="form-control" id="title" name="title" required autofocus>
      @foreach(['Mr', 'Ms', 'Mrs', 'Dr'] as $title)
      <option value="{{ $title }}"{{ $title==$advisor->title ?  ' selected' : '' }}>{{ $title }}</option>
      @endforeach
    </select>
    @includeWhen($errors->has('title'), 'common.input-error', ['error' => $errors->first('title')])
  </div>
</div>

<div class="form-group row align-items-center">
  <label for="duty-role" class="col-lg-4 col-form-label text-lg-right">Duty advisor</label>
  <div class="col-lg-6">
    <div class="custom-control custom-checkbox" id="duty-role">
      <input type="checkbox" class="custom-control-input" id="duty" name="duty"{{ $advisor->duty ? ' checked' : '' }}>
      <label class="custom-control-label" for="duty">Yes</label>
    </div>
    @includeWhen($errors->has('duty'), 'common.input-error', ['error' => $errors->first('duty')])
  </div>
</div>

<div class="form-group row align-items-center">
  <label for="admin-role" class="col-lg-4 col-form-label text-lg-right">Admin user</label>
  <div class="col-lg-6">
    <div class="custom-control custom-checkbox" id="admin-role">
      <input type="checkbox" class="custom-control-input" id="admin" name="admin"{{ $advisor->admin ? ' checked' : '' }}>
      <label class="custom-control-label" for="admin">Yes</label>
    </div>
    @includeWhen($errors->has('admin'), 'common.input-error', ['error' => $errors->first('admin')])
  </div>
</div>

<div class="form-group row pt-4">
  <div class="col-lg-5 offset-md-4">
    <button type="submit" class="btn btn-primary">Finish {{ $action }}</button>
  </div>
</div>
