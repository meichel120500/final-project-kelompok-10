@extends('layouts.app')

@section('content')
<div class="dashboard-items topupsukses">
    <div class="img-sukses">
        <img src="{{asset('assets/sukses.png')}}" alt="sukses" />
    </div>
    <div class="txt-sukses"><h2>Payment Complete!</h2></div>
    <div class="txt-sukses">
        <h3>Now your balance have been payed!</h3>
    </div>
    <div class="btn-dashboard">
        <a href="{{url('/')}}">Back to Dashboard</a>
    </div>
</div>
@endsection