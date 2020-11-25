@csrf
<div class="form-group row">
  <label for="first_name" class="col-lg-4 col-form-label text-lg-right">First name *</label>
  <div class="col-lg-5">
    <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name', $user->first_name) }}" required autofocus>
    @includeWhen($errors->has('first_name'), 'common.input-error', ['error' => $errors->first('first_name')])
    <div class="invalid-feedback">Make sure a first name is included.</div>
  </div>
</div>

<div class="form-group row">
  <label for="last_name" class="col-lg-4 col-form-label text-lg-right">Last name *</label>
  <div class="col-lg-5">
    <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
    @includeWhen($errors->has('last_name'), 'common.input-error', ['error' => $errors->first('last_name')])
    <div class="invalid-feedback">Make sure a last name is included.</div>
  </div>
</div>

@if($action=='registration')
<div class="form-group row">
  <label for="role" class="col-lg-4 col-form-label text-lg-right">Role *</label>
  <div class="col-lg-5">
    <select id="role" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" id="role" name="role">
      <option value="student">Student</option>
      <option value="advisor">Advisor</option>
      <option value="staff">Staff</option>
    </select>
    @includeWhen($errors->has('role'), 'common.input-error', ['error' => $errors->first('role')])
  </div>
</div>
<div class="form-group row">
  <label for="profile_photo" class="col-lg-4 col-form-label text-lg-right">Profile photo</label>
  <div class="col-lg-5 custom-file{{ $errors->has('profile_photo') ? ' mb-3' : '' }}">
    <input id="profile_photo" type="file" class="custom-file-input{{ $errors->has('profile_photo') ? ' is-invalid' : '' }}" name="profile_photo" accept="image/*">
    <label class="custom-file-label ml-3 mr-3" for="profile_photo">Choose file...</label>
    @includeWhen($errors->has('profile_photo'), 'common.input-error', ['error' => $errors->first('profile_photo')])
  </div>
</div>
@else
{{-- TODO: fetch & display new image when upload finished --}}
<div class="form-group row">
  <label class="col-lg-4 col-form-label text-lg-right">Profile photo</label>
  <div class="col-lg-1 d-flex justify-content-center">
    <img src="{{ $user->profile_photo() }}" class="rounded" height="50" width="50" alt="Profile photo">
  </div>
  <div class="col-lg-4 custom-file{{ $errors->has('profile_photo') ? ' mb-3' : '' }}">
    <input id="profile_photo" type="file" class="custom-file-input{{ $errors->has('profile_photo') ? ' is-invalid' : '' }}" name="profile_photo" accept="image/*">
    <label class="custom-file-label mr-3" for="profile_photo">Change photo...</label>
    @includeWhen($errors->has('profile_photo'), 'common.input-error', ['error' => $errors->first('profile_photo')])
  </div>
</div>
@endif


<div class="form-group row">
  <label for="email" class="col-lg-4 col-form-label text-lg-right">Email Address *</label>
  <div class="col-lg-5">
    <input placeholder="...@uwcisak.jp" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', $user->email) }}" required>
    @includeWhen($errors->has('email'), 'common.input-error', ['error' => $errors->first('email')])
    <div class="invalid-feedback">Make sure you include an email address.</div>
  </div>
</div>

<div class="form-group row pt-4">
  <div class="col-lg-5 offset-md-4">
    <button type="submit" class="btn btn-primary">Continue {{ $action }}</button>
  </div>
</div>
