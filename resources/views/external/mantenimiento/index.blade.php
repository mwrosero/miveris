@extends('template.external')
@section('title')
Veris - Mantenimiento
@endsection
@push('css')
<!-- css -->
@endpush
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/theme-veris-app.css?v=1.0')}}">
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/veris-helper.js"></script>

@include('external.components.navbar')

<div class="flex-grow-1 container-p-y pt-0">
    <section class="p-3 pt-5 mb-3 mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card bg-transparent">
                    <div class="card-body text-center">
                        <div class="card-header text-center">
                            <img class="w-50" src="{{ asset('assets/external/mantenimiento/mantenimiento.svg') }}" alt="">
                        </div>
                        <div class="card-body p-0 m-0 mb-3 pt-3">
                            <h5 class="mb-0">Lo sentimos, nos encontramos en mantenimiento.</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection