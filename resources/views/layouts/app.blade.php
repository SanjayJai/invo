<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | {{ getAppName() }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset(getSettingValue('favicon_icon')) }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="current-date-format" content="{{ currentDateFormat() }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    <!-- General CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('assets/css/page.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @if (!Auth::user()->dark_mode)
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins.css') }}">
        <link href="{{ mix('assets/css/full-screen.css') }}" rel="stylesheet" type="text/css" />
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.dark.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins.dark.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/phone-number-dark.css') }}">
        <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    @endif
    @livewireStyles
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js"
        data-turbolinks-eval="false" data-turbo-eval="false"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js" data-turbolinks-eval="false" data-turbo-eval="false">
    </script>
    <script src="{{ asset('assets/js/third-party.js') }}"></script>
    <script src="{{ asset('messages.js') }}"></script>



    
    <script data-turbo-eval="false">
        let sweetAlertIcon = "{{ asset('images/remove.png') }}";
        let decimalsSeparator = "{{ getSettingValue('decimal_separator') }}";
        let thousandsSeparator = "{{ getSettingValue('thousand_separator') }}";
        let changePasswordUrl = "{{ route('user.changePassword') }}";
        let currentDateFormat = "{{ currentDateFormat() }}";
        let momentDateFormat = "{{ momentJsCurrentDateFormat() }}";
        var phoneNo = '';
        let getUserLanguages = "{{ getCurrentLanguageName() }}";
        Lang.setLocale(getUserLanguages);
        let currentRouteName = "{{ Route::currentRouteName() }}";
    </script>
    @routes
    <script src="{{ mix('assets/js/pages.js') }}"></script>
</head>

<body class="overflow-x-hidden">
    @yield('phone_js')
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid">
            @include('layouts.sidebar')
            <div class="wrapper d-flex flex-column flex-row-fluid overflow-x-hidden">
                <div class='container-fluid d-flex align-items-stretch justify-content-between px-0'>
                    @include('layouts.header')
                </div>
                <div class='content d-flex flex-column flex-column-fluid pt-7'>
                    @yield('header_toolbar')
                    <div class='d-flex flex-wrap flex-column-fluid'>
                        @yield('content')
                    </div>
                </div>
                <div class='container-fluid'>
                    @include('layouts.footer')
                </div>
            </div>
        </div>
    </div>
    @include('profile.changePassword')
    @include('profile.changelanguage')
</body>


</html>
