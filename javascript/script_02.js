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

//Funcion de los botones de deudas
document.addEventListener("DOMContentLoaded", function () {
    const tablaDeudas = document.getElementById("tablaDeudas");

    // Editar fila
    tablaDeudas.addEventListener("click", function (event) {
        if (event.target.id === "editar") {
            const row = event.target.closest("tr");
            const desc = row.querySelector(".desc");
            const monto = row.querySelector(".monto");
            const fecha = row.querySelector(".fecha");

            if (event.target.innerText === "Editar") {
                // Habilitar edición
                desc.contentEditable = true;
                monto.contentEditable = true;
                fecha.contentEditable = true;
                event.target.innerText = "Guardar";
                row.classList.add("editing");
            } else {
                // Guardar cambios
                const idDeuda = row.getAttribute("data-id");
                const nuevaDesc = desc.innerText;
                const nuevoMonto = monto.innerText;
                const nuevaFecha = fecha.innerText;

                fetch("actualizar_deuda.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        idDeuda: idDeuda,
                        DeudaDesc: nuevaDesc,
                        DeudaMonto: nuevoMonto,
                        DeudaFecha: nuevaFecha,
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            alert("Deuda actualizada correctamente.");
                            desc.contentEditable = false;
                            monto.contentEditable = false;
                            fecha.contentEditable = false;
                            event.target.innerText = "Editar";
                            row.classList.remove("editing");
                        } else {
                            alert("Error al actualizar la deuda.");
                        }
                    })
                    .catch((error) => console.error("Error:", error));
            }
        }
    });

    // Eliminar fila
    tablaDeudas.addEventListener("click", function (event) {
        if (event.target.classList.contains("eliminar")) {
            const row = event.target.closest("tr");
            const idDeuda = row.getAttribute("data-id");

            if (confirm("¿Estás seguro de que deseas eliminar esta deuda?")) {
                fetch("eliminar_deuda.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ idDeuda: idDeuda }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            alert("Deuda eliminada correctamente.");
                            row.remove();
                        } else {
                            alert("Error al eliminar la deuda.");
                        }
                    })
                    .catch((error) => console.error("Error:", error));
            }
        }
    });
});
