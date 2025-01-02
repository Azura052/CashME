// Función para mostrar/ocultar tabs
function showTab(tabId) {
    document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.remove('active');
    });
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    
    document.getElementById(tabId).classList.add('active');
    document.querySelector(`button[onclick="showTab('${tabId}')"]`).classList.add('active');
}

// Validación de email
function validarEmail(email) {
    const dominiosPermitidos = [
        '@gmail.com', '@hotmail.com', '@outlook.com', '@yahoo.com', '@icloud.com', '@protonmail.com', '@aol.com', '@live.com', '@msn.com', '@mail.com', '@zoho.com', '@gmx.com', '@yandex.com','@gmail.es', '@hotmail.es', '@outlook.es', '@yahoo.es'];
    return dominiosPermitidos.some(dominio => email.toLowerCase().endsWith(dominio));
}

// Validación de teléfono
function validarTelefono(telefono) {
    return /^[0-9]{10}$/.test(telefono);
}

// Validación de código postal
function validarCodigoPostal(cp) {
    return /^[0-9]{5}$/.test(cp);
}

// Mostrar error
function mostrarError(campo, mostrar = true) {
    const error = document.getElementById(`${campo}-error`);
    const input = document.getElementById(campo);
    if (mostrar) {
        error.style.display = 'block';
        input.classList.add('invalid');
    } else {
        error.style.display = 'none';
        input.classList.remove('invalid');
    }
}

// Validar campos de la primera pestaña
function validarPrimeraTab() {
    let isValid = true;
    const campos = ['nombre', 'apellidoPaterno', 'apellidoMaterno', 'telefono', 'email', 'password', 'confirmPassword'];
    
    campos.forEach(campo => {
        const valor = document.getElementById(campo).value;
        
        if (!valor) {
            mostrarError(campo);
            isValid = false;
        } else {
            mostrarError(campo, false);
            
            // Validaciones específicas
            switch(campo) {
                case 'email':
                    if (!validarEmail(valor)) {
                        mostrarError(campo);
                        isValid = false;
                    }
                    break;
                case 'telefono':
                    if (!validarTelefono(valor)) {
                        mostrarError(campo);
                        isValid = false;
                    }
                    break;
                case 'password':
                    if (valor.length < 8) {
                        mostrarError(campo);
                        isValid = false;
                    }
                    break;
                case 'confirmPassword':
                    if (valor !== document.getElementById('password').value) {
                        mostrarError(campo);
                        isValid = false;
                    }
                    break;
            }
        }
    });
    
    return isValid;
}

// Validar y avanzar a la siguiente pestaña
function validarYAvanzar() {
    if (validarPrimeraTab()) {
        showTab('direccion');
    }
}

// Validar campos de la segunda pestaña
function validarSegundaTab() {
    let isValid = true;
    const campos = ['estado', 'codigoPostal', 'colonia', 'calle'];
    
    campos.forEach(campo => {
        const valor = document.getElementById(campo).value;
        
        if (!valor) {
            mostrarError(campo);
            isValid = false;
        } else {
            mostrarError(campo, false);
            
            // Validación específica para código postal
            if (campo === 'codigoPostal' && !validarCodigoPostal(valor)) {
                mostrarError(campo);
                isValid = false;
            }
        }
    });
    
    return isValid;
}

// Limpiar formulario
function limpiarFormulario() {
    document.getElementById('registroForm').reset();
    document.querySelectorAll('.error').forEach(error => {
        error.style.display = 'none';
    });
    document.querySelectorAll('input').forEach(input => {
        input.classList.remove('invalid');
    });
    showTab('personal');
}

// Manejar envío del formulario
/*document.getElementById('registroForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch(window.location.href, {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('Usuario registrado exitosamente');
            limpiarFormulario();
        } else {
            alert('Error al registrar usuario: ' + result.error);
        }
    } catch (error) {
        alert('Error al procesar la solicitud');
        console.error('Error:', error);
    }
});

document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', () => {
        switchTab(tab.dataset.tab);
    });
});*/
