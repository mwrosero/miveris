@extends('template.login')
@section('title')
    Veris - Actualizar Contraseña
@endsection
@section('content')
<!-- Content Actualizar Clave -->
<p class="fs-4 mb-1 pt-2 text-center bg-colortext fw-bold">Recuperando Contraseña</p>
<p class="fs-10 mb-3 text-center bg-colortext">Para actualizar la contraseña debes ingresar el código de validación enviado a tu correo electrónico registrado</p>

<form id="formAuthentication" class="mb-3" method="post" action="/actualizar-clave" onsubmit="return validarClave()">
    @csrf
    <input type="hidden" name="usuario" value="{{ $usuario }}">
    @if (session()->has('mensaje'))
        <div class="alert alert-warning">
        {{ session('mensaje') }}
        </div>
    @endif
    <div class="mb-2">
        <label for="codigo" class="form-label bg-colortext fw-bold mt-2">Código de validación</label>
        <input type="text"
            class="form-control"
            id="codigo"
            name="codigo"
            autofocus
            required 
            value="{{ $codigo }}" />
    </div>
    <div class="mb-2">
        <label for="nuevaClave" class="form-label bg-colortext fw-bold mt-2">Nueva contraseña</label>
        <div class="input-group input-group-merge">
            <input type="password"
                class="form-control"
                id="nuevaClave"
                name="nuevaClave"
                autofocus
                required />
            <span id="togglePassword" class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
        </div>
    </div>
    <div class="mb-3">
        <label for="confirmarClave" class="form-label bg-colortext fw-bold mt-2">Confirmar nueva contraseña</label>
        <div class="input-group input-group-merge">
            <input type="password"
                class="form-control"
                id="confirmarClave"
                name="confirmarClave"
                autofocus
                required />
            <span id="togglePassword2" class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
        </div>
    </div>
    <div class="mb-3">
        <button class="btn btn-primary d-grid w-100 bg-colorboton" type="submit" id="recuperarContrasena">Actualizar Contraseña</button>
    </div>
</form>
<!-- /Content Actualizar Clave -->
<script>
    function validarClave() {
        var nuevaClave = document.getElementById("nuevaClave").value;
        var confirmarClave = document.getElementById("confirmarClave").value;
        
        // Validar longitud mínima de 8 caracteres
        if (nuevaClave.length < 8) {
            showMessage('warning','Atención',"La nueva contraseña debe tener al menos 8 caracteres.");
            return false;
        }
        
        // Validar que las contraseñas coincidan
        if (nuevaClave !== confirmarClave) {
            showMessage('warning','Atención',"Las contraseñas no coinciden.");
            return false;
        }
        
        // Validar requisitos de complejidad
        var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#*$%^&+=!¡¿?])[0-9a-zA-Z@#*$%^&+=!¡¿?]{8,}$/;
        if (!re.test(nuevaClave)) {
            showMessage('warning','Atención',"La contraseña debe incluir al menos: <ul><li>Incluir Números</li><li>Incluir Mayúsculas</li><li>Incluir Minúsculas</li><li>Tamaño mínimo 8</li><li>Caracteres especiales</li></ul>");
            return false;
        }
        
        return true;
    }

    const passwordInput = document.getElementById('nuevaClave');
    const passwordInput2 = document.getElementById('confirmarClave');
    const togglePassword = document.getElementById('togglePassword');
    const togglePassword2 = document.getElementById('togglePassword2');

    togglePassword.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePassword.innerHTML = '<i class="ti ti-eye"></i>';
        } else {
            passwordInput.type = 'password';
            togglePassword.innerHTML = '<i class="ti ti-eye-off"></i>';
        }
    });

    togglePassword2.addEventListener('click', function() {
        if (passwordInput2.type === 'password') {
            passwordInput2.type = 'text';
            togglePassword2.innerHTML = '<i class="ti ti-eye"></i>';
        } else {
            passwordInput2.type = 'password';
            togglePassword2.innerHTML = '<i class="ti ti-eye-off"></i>';
        }
    });
</script>
@endsection