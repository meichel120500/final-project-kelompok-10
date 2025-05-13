<div class="sidebar">
    <h1>10<span>Exchange</span></h1>
    <div class="items">
        <div class="dashboard">
            <a href="{{ url('/') }}"
                ><img src="{{ asset('assets/dashboard.png') }}" alt="" />
                <span class="sidebar-text"><h2>Dashboard</h2></span>
            </a>
        </div>
        <div class="saldo">
            <a href="{{ route('saldo') }}"
                ><img src="{{ asset('assets/saldo.png') }}" alt="" />
                <span class="sidebar-text"><h2>Balance</h2></span>
            </a>
        </div>
        <div class="transaksi">
            <ul class="dropdown2">
                <li id="dropdown-trigger2">
                    <a href="#sdf"
                        ><img
                            src="{{ asset('assets/transaksi.png') }}"
                            alt=""
                        />
                        <span><h2>Transaction</h2></span>
                        <i class="fas fa-caret-down"></i>
                    </a>
                </li>
                <li id="item-dropdown-topup">
                    <a href="{{route('top_up')}}"
                        >Top Up</a
                    >
                </li>
                <li id="#">
                    <a href="#"></a>
                </li>
                <li id="item-dropdown-konvertuang">
                    <a
                        href="{{route('convert')}}"
                        >Convert Currency</a
                    >
                </li>
                <li id="item-dropdown-payment">
                    <a href="{{route('payment')}}">Payment</a>
                </li>
                <li id="item-dropdown-historitrans">
                    <a href="{{route('history')}}"
                        >Transaction history</a
                    >
                </li>
            </ul>
        </div>
        <div class="akun">
            <ul class="dropdown">
                <li id="dropdown-trigger">
                    <a href="#sdfea"
                        ><img
                            src="{{ asset('assets/akun.png') }}"
                            alt=""
                        />
                        <span><h2>Account</h2></span>
                        <i class="fas fa-caret-down"></i>
                    </a>
                </li>
                <li id="item-dropdown1">
                    <a href="{{route('profil')}}"
                        >Profile Details</a
                    >
                </li>
                <li id="item-dropdown2">
                    <a
                        href="{{route('security_account')}}"
                        >Security Account</a
                    >
                </li>
            </ul>
        </div>
        <div class="guide">
            <a href="{{route('guide')}}"
                ><img src="{{ asset('assets/guide.png') }}" alt="" />
                <span class="sidebar-text"><h2>Guide</h2></span>
            </a>
        </div>
        <div class="logout">
            <a href="{{ route('logout') }}">
                <img src="{{ asset('assets/logout.png') }}" alt="" />
                <span><h2>Logout</h2></span>
            </a>
        </div>
    </div>
</div>