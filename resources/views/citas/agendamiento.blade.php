@extends('template.app-template-veris')
@section('title')
Mi Veris - Agendamiento Cita
@endsection
@section('content')
<div id="steps"></div>
@endsection
@push('scripts')
<script>
    $.ajax({
        url: '/citas-elegir-paciente',
        type: 'GET',
        success: function(response) {
            $('#steps').html(response);
        },
        error: function(error) {
            console.log(error);
        }
    });

</script>
@endpush