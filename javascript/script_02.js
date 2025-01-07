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
    console.log("Script cargado correctamente.");

    const editarBtn = document.getElementById("editar");
    const guardarBtn = document.getElementById("guardar");
    const tabla = document.getElementById("tablaDeudas");

    if (!editarBtn || !guardarBtn || !tabla) {
        console.error("Error: Algunos elementos no se encontraron.");
        return;
    }

    // Habilitar edición
    editarBtn.addEventListener("click", () => {
        console.log("Botón Editar presionado.");
        const filas = tabla.querySelectorAll("tbody tr");
        filas.forEach(fila => {
            const celdas = fila.querySelectorAll("td");
            celdas.forEach(celda => {
                celda.setAttribute("contenteditable", "true");
                celda.style.border = "1px solid #ddd";
            });
        });
        guardarBtn.style.visibility = "visible";
        editarBtn.style.visibility = "hidden";
    });

    // Guardar cambios
    guardarBtn.addEventListener("click", () => {
        console.log("Botón Guardar presionado.");
        const filas = tabla.querySelectorAll("tbody tr");
        const datos = [];

        filas.forEach(fila => {
            const celdas = fila.querySelectorAll("td");
            const desc = celdas[0].innerText.trim();
            const monto = celdas[1].innerText.trim();
            const fecha = celdas[2].innerText.trim();
            const id = fila.dataset.id;
            datos.push({ id, desc, monto, fecha });
        });

        console.log("Datos a guardar:", datos);

        fetch("guardar_deudas.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ deudas: datos }),
        })
        .then(response => response.json())
        .then(data => {
            console.log("Respuesta del servidor:", data);
            if (data.success) {
                alert("Datos guardados correctamente");
                filas.forEach(fila => {
                    const celdas = fila.querySelectorAll("td");
                    celdas.forEach(celda => {
                        celda.setAttribute("contenteditable", "false");
                        celda.style.border = "none";
                    });
                });
                guardarBtn.style.visibility = "hidden";
                editarBtn.style.visibility = "visible";
            } else {
                console.error("Error del servidor:", data.error || "Error desconocido");
                alert("Error al guardar los datos: " + (data.error || "Error desconocido"));
            }
        })
        .catch(error => {
            console.error("Error de conexión o de servidor:", error);
            alert("Hubo un error al guardar los datos");
        });
    });

    // Eliminar fila
    tabla.addEventListener("click", (event) => {
        if (event.target.classList.contains("eliminar")) {
            const fila = event.target.closest("tr");
            const id = fila.dataset.id;

            // Confirmar antes de eliminar
            if (confirm("¿Estás seguro de que deseas eliminar esta deuda?")) {
                fetch("eliminar_deuda.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ id }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Deuda eliminada correctamente");
                        fila.remove(); // Eliminar la fila visualmente
                    } else {
                        console.error("Error al eliminar:", data.error || "Error desconocido");
                        alert("Error al eliminar la deuda: " + (data.error || "Error desconocido"));
                    }
                })
                .catch(error => {
                    console.error("Error de conexión o de servidor:", error);
                    alert("Hubo un error al eliminar la deuda");
                });
            }
        }
    });
});
