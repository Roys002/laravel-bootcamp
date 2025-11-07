@extends('layouts/contentNavbarLayout')
@section('title', 'Product')

@extends('layouts/contentNavbarLayout')
@section('title', 'Product')

@section('content')
<div id="app" class="w-full max-w-2xl mx-auto p-2 bg-white rounded-lg shadow-lg">
    <product-list></product-list>
</div>
@endsection

@push('page-script')
@vite(['resources/js/app.js'])
@endpush

@push('page-style')
@vite(['resources/css/app.css'])
@endpush