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

document.addEventListener('DOMContentLoaded', function () {
    // Editar funcionalidad
    document.querySelectorAll('.editar').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            row.querySelectorAll('td[contenteditable="false"]').forEach(cell => {
                cell.contentEditable = "true";
            });
            this.style.display = "none"; // Oculta el botón Editar
            row.querySelector('.guardar').style.display = "inline-block"; // Muestra el botón Guardar
        });
    });

    // Guardar cambios
    document.querySelectorAll('.guardar').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const id = row.dataset.id;
            const desc = row.querySelector('.desc').textContent.trim();
            const monto = row.querySelector('.monto').textContent.trim();
            const fecha = row.querySelector('.fecha').textContent.trim();

            // Enviar datos al servidor con AJAX
            fetch('actualizar_deuda.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, desc, monto, fecha })
            })
            .then(response => response.text())
            .then(data => {
                if (data === 'success') {
                    alert('Deuda actualizada correctamente.');
                } else {
                    alert('Error al actualizar la deuda.');
                }
                // Bloquea las celdas nuevamente
                row.querySelectorAll('td[contenteditable="true"]').forEach(cell => {
                    cell.contentEditable = "false";
                });
                this.style.display = "none"; // Oculta el botón Guardar
                row.querySelector('.editar').style.display = "inline-block"; // Muestra el botón Editar
            });
        });
    });

    // Eliminar funcionalidad
    document.querySelectorAll('.eliminar').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const id = row.dataset.id;

            if (confirm('¿Estás seguro de que deseas eliminar esta deuda?')) {
                // Enviar solicitud al servidor para eliminar
                fetch('eliminar_deuda.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id })
                })
                .then(response => response.text())
                .then(data => {
                    if (data === 'success') {
                        row.remove(); // Elimina la fila del DOM
                        alert('Deuda eliminada correctamente.');
                    } else {
                        alert('Error al eliminar la deuda.');
                    }
                });
            }
        });
    });
});
