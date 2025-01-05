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

document.addEventListener("DOMContentLoaded", () => {
    const tabla = document.getElementById("tabla"); // Identificar la tabla
    const botonEditar = document.getElementById("editarFilas"); // Botón externo

    // Evento para alternar entre editar y guardar
    botonEditar.addEventListener("click", () => {
        const filas = tabla.querySelectorAll("tr:not(:first-child)"); // Seleccionar todas las filas excepto el encabezado
        const esModoEditar = botonEditar.textContent === "Editar Filas";

        filas.forEach((fila) => {
            const celdas = fila.querySelectorAll("td"); // Seleccionar todas las celdas de la fila

            celdas.forEach((celda) => {
                if (esModoEditar) {
                    // Convertir celdas a campos de entrada
                    const valorActual = celda.textContent.trim();
                    celda.innerHTML = `<input type="text" value="${valorActual}" style="width: 100%;">`;
                } else {
                    // Guardar los cambios y restaurar el texto
                    const input = celda.querySelector("input");
                    if (input) {
                        celda.textContent = input.value.trim(); // Reemplazar el contenido de la celda
                    }
                }
            });
        });

        // Alternar el texto del botón entre "Editar Filas" y "Guardar Cambios"
        botonEditar.textContent = esModoEditar ? "Guardar Cambios" : "Editar Filas";
    });
});

