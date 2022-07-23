<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }} | {{ $title }}</title>

    <link href="/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('HomeIndex') }}">@if(auth()->check()) {{ auth()->user()->name }} @else {{ env('APP_NAME') }} @endif</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('HomeIndex') }}">{{ __('home') }}</a>
                </li>
                @if(auth()->check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('CategoriesIndex') }}">{{ __('categories') }}</a>
                    </li>
                    <li class="nav-item">
                        <form method="post" action="{{ route('HomeLogout') }}">
                            @csrf
                            <button type="submit" class="nav-link border-0 bg-transparent">{{ __('logout') }}</button>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">
    {{ $slot }}
</div>

<script src="/libs/jquery/jquery-3.6.0.min.js"></script>
<script src="/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<x-datatable-files tableId="media_list"></x-datatable-files>
</body>
</html>
