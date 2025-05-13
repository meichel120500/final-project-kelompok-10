@extends('layouts.app')

@section('content')
<h2>Security Account</h2>
<h2>Change Password</h2>

@include('includes/flash_messages')

<!-- input profile -->
<form action="{{ route('ganti_password')}}" method="post">
  @csrf
  <div class="profile item2">
      <div>
      <h2>Current Password</h2>
      <input name="current-password" type="password" name="password" placeholder="rakamin" />
      </div>
  </div>
  <div class="profile item2">
      <div>
      <h2>New Password</h2>
      <input name="new-password" type="password" name="password" placeholder="rakamin" />
      </div>
      <div>
      <h2>Confirm New Password</h2>
      <input name="confirm-password" type="password" name="password" placeholder="rakamin" />
      </div>
  </div>
  <div class="profile item3">
      <div class="save-changes">
      <button type="submit">Save Changes</button>
      </div>
  </div>
</form>
@endsection