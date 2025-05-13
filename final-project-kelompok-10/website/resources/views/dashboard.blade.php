@extends('layouts.app')

@section('content')
<h2>Dashboard</h2>
<div class="dashboard-items">
  <div class="welcome">
      <h2>Welcome to 10Exchange!<br /><span>Rakamin {{session()->get('username')}}</span></h2>
  <div class="Balance">
      <h2>Your Balance After Exchange<br /><span>{{$nama_mata_uang_convert}} {{$saldo_exchange->saldo ?? 0}}</span></h2>
      </div>
  </div>
  <div class="saldo-user">
    <h2>Your Balance<br /><span>Rp. {{$saldo_rupiah->saldo ?? 0}}</span></h2>
  </div>
</div>
@endsection
