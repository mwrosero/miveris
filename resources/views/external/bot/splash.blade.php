<link rel="stylesheet" href="{{ asset('assets/css/splash.css?v=1.0')}}">
<canvas id="canvas"></canvas>
<div class="copy">
    <h1>
        Vericita</br>
        <img class="logo-login" src="../../assets/img/veris/isotipo.svg">
    </h1>
</div>
<script src="{{ request()->getHost() === '127.0.0.1' ? url('/') : secure_url('/') }}/assets/js/splash.js"></script>