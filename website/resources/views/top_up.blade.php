@extends('layouts.app')

@section('content')
<div class="text-dashboard">
    <h2>Top Up</h2>
</div>
<div class="dashboard-items-topup">
    <div class="saldo-user">
        <h2>Your Balance<br /><span>Rp. {{$saldo->saldo ?? 0}}</span></h2>
    </div>
    <div class="txt-balance">
        <h2>Insert the Balance</h2>
    </div>
    <form action="{{route('top_up.submit')}}" method="post">
        @csrf
        <div class="insert-balance">
            <span>Rp.</span>
            <input
                type="number"
                inputmode="numeric"
                name='jumlah_top_up'
                placeholder="0"
            />
        </div>
        <div class="btn-topup">
            <button type="submit" class="btn">Top Up Now</button>
        </div>
    </form>
</div>
@endsection
