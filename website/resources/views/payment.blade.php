@extends('layouts.app')

@section('content')
<div class="text-dashboard">
    <h2>Payment</h2>
</div>
<div class="dashboard-items-topup">
    @include('includes/flash_messages')
    <div class="saldo-user">
        <h2>Your Balance<br /><span>Rp. {{$saldo->saldo ?? 0}}</span></h2>
    </div>
    <div class="txt-balance">
        <h2>Insert the Balance</h2>
    </div>
    <form action="{{ route('payment.submit')}}" method="post">
        @csrf
        <div class="insert-balance">
            <span>Rp. </span>
            <input
                type="number"
                name="jumlah_payment"
                id="jumlah_payment"
                inputmode="numeric"
                placeholder="0"
            />
        </div>
        <div class="btn-topup">
            <button type="submit" class="btn">Pay Now</button>
        </div>
    </form>
</div>
@endsection