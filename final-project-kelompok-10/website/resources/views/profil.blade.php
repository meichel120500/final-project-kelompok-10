@extends('layouts.app')

@section('content')
<h2>Profile Details</h2>
  @include('includes/flash_messages')
  <div class="profile item1">
    <div class="user-img">
      <img src="{{ asset('assets/person.png') }}" id="photo" />
    </div>
  </div>

  <!-- input profile -->
  <form action="{{route('simpan_profil')}}" method="post">
    @csrf
    <div class="profile item2">
      <div>
        <h2>First Name</h2>
        <input name="first-name" type="text" name="firstname" value="{{$firstName}}" />
      </div>
      <div>
        <h2>Last Name</h2>
        <input name="last-name" type="text" name="lastname" value="{{$lastName}}" />
      </div>
    </div>
    <div class="profile item2">
      <div>
        <h2>Username</h2>
        <input name="username" type="text" name="username" value="{{session()->get('username')}}" />
      </div>
      <div>
        <h2>Email</h2>
        <input name="email" type="email" name="email" value="{{session()->get('email')}}" />
      </div>
    </div>
    <div class="profile item2">
      <div>
        <h2>Phone Number</h2>
        <input name="no-hp" type="number" name="firstName" value="{{$account_user->phone_number ?? ''}}" />
      </div>
      <div>
        <h2>City</h2>
        <input name="city" type="text" name="lastName" value="{{$account_user->city ?? ''}}" />
      </div>
    </div>
    <div class="profile item3">
      <div>
        <h2>Address</h2>
        <input name="address" type="text" name="address" value="{{$account_user->address ?? ''}}" />
      </div>
      <div class="save-changes">
        <button type="submit">Save Changes</button>
      </div>
    </div>
  </form>
@endsection