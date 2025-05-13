@extends('layouts.app')

@section('content')
<h2>Dashboard</h2>
<div class="text-dashboard">
  <h2>Balance</h2>
</div>
<div class="dashboard-items">
  <div class="saldo-user">
      <h2>Your Last Balance<br /><span>Rp. {{$saldo_rupiah->saldo ?? 0}}</span></h2>
  </div>
  <div class="transfer-uang">
      <h2>Total Money Transfer<br /><span>Rp. {{$money_transfer->total ?? 0}}</span></h2>
  </div>
</div>
<div class="dashboard-items2">
  <div class="total-pendapatan">
      <h2>Total Money Income<br /><span>Rp. {{$money_income->total ?? 0}}</span></h2>
  </div>
  <div class="penukaran-uang">
      <h2>
          Your Currency After Exchange<br /><span
              >{{$nama_mata_uang_convert}} {{$saldo_exchange->saldo ?? 0}}
          </span>
      </h2>
  </div>
</div>
<section id="svg-path">
  <section id="card"></section>
</section>

<div class="chart" style="margin-top:200px;">
  <div id="chartAmount"></div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
  var data = @json($exchange_rates_in_1_month);
  var dates = @json($dates); // Convert the PHP $dates array to a JavaScript array
  var count_days = dates.length;
  Highcharts.chart('chartAmount', {
      chart: {
          type: 'area'
      },
      title: {
          text: 'Exchange Rates for the Past '+count_days+' Days'
      },
      xAxis: {
          categories: dates, // Use the $dates array as X-axis categories
          title: {
              text: 'Date'
          }
      },
      yAxis: {
          title: {
              text: 'Exchange Rate'
          }
      },
      tooltip: {
          pointFormat: 'Exchange Rate: <b>{point.y:.2f}</b>'
      },
      series: [{
          name: 'IDR in {{$convert_code}}',
          data: data // Use your exchange rate data here
      }]
  });

</script>
@endsection