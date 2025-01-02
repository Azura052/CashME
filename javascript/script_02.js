function limpiarFormulario() {
    const formulario = document.querySelector('form');
    if (formulario) {
        formulario.reset();
    }
}

//Mostrar mensaje de error de login

function validateForm(event) {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    
    // Resetear mensajes de error
    emailError.classList.remove('visible');
    passwordError.classList.remove('visible');
    
    let isValid = true;

    // Validar email
    if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
        emailError.textContent = 'Por favor, ingresa un correo electrónico válido';
        emailError.classList.add('visible');
        isValid = false;
    }

    // Validar contraseña
    if (password.length < 6) {
        passwordError.textContent = 'La contraseña debe tener al menos 6 caracteres';
        passwordError.classList.add('visible');
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault();
    }

    return isValid;
}