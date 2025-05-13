@extends('layouts.app')

@section('content')
<div class="text-dashboard">
    <h2>Convert Currency</h2>
</div>
<div class="dashboard-items-currency">
    @include('includes/flash_messages')
    <form action="{{route('convert.submit')}}" method="post">
        @csrf
        <div class="saldo-user">
            <h2>Your Balance<br /><span>Rp. {{$saldo->saldo ?? 0}}</span></h2>
        </div>
        <div class="txt-currency">
            <h2>Insert the Balance</h2>
        </div>
        <div class="cnvrt-currency">
            <div>
                <div class="txt-currency2">
                    <h2>Amount</h2>
                </div>
                <div class="insert-currency">
                    <input
                        id='amount-needed'
                        type="number"
                        inputmode="numeric"
                        placeholder="0"
                        readonly
                    />
                    <div class="select">
                        <select name="format" id="format-amount">
                            <option selected disabled>
                                Choose Currency
                            </option>
                            <option value="IDR" selected>IDR</option>
                        </select>
                    </div>
                </div>
            </div>
            <div>
                <div class="txt-currency2">
                    <h2>Convert to</h2>
                </div>
                <div class="insert-currency">
                    <input
                        id='convert-amount'
                        type="number"
                        inputmode="numeric"
                        name="jumlah_convert"
                        placeholder="0"
                    />
                    <div class="select">
                        <select id="format-convert" name="selected_kode_mata_uang">
                            <option disabled>
                                Choose Currency
                            </option>
                            @foreach ($currencies as $currency)
                                <option 
                                value="{{$currency->kode_mata_uang}}"
                                @if ($currency->id == $currency_mode)
                                    selected
                                @endif
                                >{{$currency->kode_mata_uang}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-currency">
            <button type="submit" class="btn">Confirm</button>
        </div>
    </form>
</div>
@endsection


@push('scripts')
    <script>
        var currencies_exchange_rates = @json($currencies_exchange_rates);
        console.log(currencies_exchange_rates);

        const amountNeededInput = document.getElementById('amount-needed');
        const convertAmountInput = document.getElementById('convert-amount');
        convertAmountInput.addEventListener('input', updateConvertedAmount);

        function updateConvertedAmount() {
            var selectElement = document.getElementById('format-convert');
            var selectedValue = selectElement.value;
            var selectedText = selectElement.options[selectElement.selectedIndex].text;


            // Parse the amounts
            const amountNeeded = parseFloat(amountNeededInput.value) || 0;
            const convertAmount = parseFloat(convertAmountInput.value) || 0;

            // Calculate the converted amount based on the exchange rate

            var convertedAmount = (convertAmount * currencies_exchange_rates[selectedText]).toFixed(2);

            // Display the converted amount
            amountNeededInput.value = convertedAmount;
        }
    </script>
@endpush