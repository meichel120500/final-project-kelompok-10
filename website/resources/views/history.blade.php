@extends('layouts.app')

@section('content')
<div class="text-dashboard">
    <h2>Transaction History</h2>
</div>
<table class="center">
    <tr>
      <th>Date</th>
      <th>Description</th>
      <th>Amount</th>
      <th>Status</th>
    </tr>
    @foreach ($transaction_history as $d)
        <tr>
            <td>{{$d->tanggal}}</td>
            <td>{{ucfirst($d->metode_pembayaran)}}</td>
            @if (empty($d->nama_mata_uang))
            <td>Rp. {{$d->jml_mata_uang_digital}}</td>
            @else
            <td>{{$d->nama_mata_uang}} {{$d->jml_mata_uang_digital}}</td>
            @endif
            <td class="text-{{$d->status_transaksi}}">{{ucfirst($d->status_transaksi)}}</td>
        </tr>
    @endforeach
  </table>
@endsection