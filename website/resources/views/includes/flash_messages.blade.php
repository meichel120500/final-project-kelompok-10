{{-- Error Flash Message --}}

{{-- 
    Pastikan kalau ingin memakai unsafe-error atau unsafe-success, 
    inputnya dikontrol penuh. Karena bisa kena XSS.

    Untuk memakai tinggal 

    @include('includes/flash_messages')

    di bagian yang ingin ditaro flash message
--}}

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<div class="error-messages">
    @if(session()->has('error'))
    <div class="alert alert-danger">
        @if (is_array(session()->get('error')))
            {{-- Also can be used to handle multiple error --}}
            @foreach (session('error') as $error)
                <li class="m-2">{{ $error }}</li>
            @endforeach
        @else
            {{ session()->get('error') }}
        @endif
    </div>
    @endif
    {{-- Unsafe Error dipakai ketika ingin memunculkan 
        flash message yang bisa dikontrol dengan elemen HTML --}}
    @if(session()->has('unsafe-error'))
    <div class="alert alert-danger">
        @if (is_array(session()->get('unsafe-error')))
            {{-- Also can be used to handle multiple error --}}
            @foreach (session('unsafe-error') as $error)
                <li class="m-2">{!! $error !!}</li>
            @endforeach
        @else
            {!! session()->get('unsafe-error') !!}
        @endif
    </div>
    @endif
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    {{-- Unsafe Success dipakai ketika ingin memunculkan
        flash message yang bisa dikontrol dengan elemen HTML --}}
    @if(session()->has('unsafe-success'))
        <div class="alert alert-success">
            {!! session()->get('unsafe-success') !!}
        </div>
    @endif
    {{-- For when there's a lot of errors to show --}}
    @if (is_array($errors))
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors as $error)
                    <li class="m-2">{{ $error }}</li>
                @endforeach
            </ul>
        </div>    
        @endif
    @else
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="m-2">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endif
    
    @if(session()->has('debug'))
        <div style="background: yellow; padding: 1rem;">
            {{ session('debug') }}
        </div>
    @endif
    @if(session()->has('info'))
        <div class="alert alert-primary">
            {{ session()->get('info') }}
        </div>
    @endif
    @if(session()->has('unsafe-info'))
        <div class="alert alert-primary">
            {!! session()->get('unsafe-info') !!}
        </div>
    @endif
</div>