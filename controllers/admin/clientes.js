document.querySelectorAll('.remove-button').forEach(button => {
    button.addEventListener('click', function () {
        // Muestra la alerta de SweetAlert2
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, desactivarlo"
        }).then((result) => {
            // Si el usuario confirma, muestra una alerta de éxito
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Desactivado!",
                    text: "El usuario ha sido desactivado.",
                    icon: "success"
                });
                // Aquí puedes agregar la lógica para eliminar el registro
            }
        });
    });
});

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