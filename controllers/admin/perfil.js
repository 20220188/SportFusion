
$('.edit-button').click(function () {
    // Abre el modal al hacer clic en el botón de editar
    $('#exampleModal1').modal('show');

    document.getElementById("editForm").addEventListener("submit", function (event) {
        // Prevenimos el comportamiento por defecto (envío del formulario)
        event.preventDefault();

        // Simulamos un guardado exitoso
        // Aquí podrías realizar una llamada Ajax para guardar los datos

        // Mostramos la alerta de SweetAlert
        Swal.fire({
            icon: "success",
            text: "Actualizado exitosamente"

        });

        // Cerramos el modal
        $('#exampleModal1').modal('hide')

    });
});



// Escuchamos el evento submit del formulario
document.getElementById("saveForm").addEventListener("submit", function (event) {
    // Prevenimos el comportamiento por defecto (envío del formulario)
    event.preventDefault();

    // Simulamos un guardado exitoso
    // Aquí podrías realizar una llamada Ajax para guardar los datos

    // Mostramos la alerta de SweetAlert
    Swal.fire({
        icon: "success",
        text: "Guardado exitosamente"

    });

    // Cerramos el modal
    $('#exampleModal').modal('hide');
});