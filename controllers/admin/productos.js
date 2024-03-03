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
            confirmButtonText: "Sí, eliminarlo"
        }).then((result) => {
            // Si el usuario confirma, muestra una alerta de éxito
            if (result.isConfirmed) {
                Swal.fire({
                    title: "¡Eliminado!",
                    text: "Tu archivo ha sido eliminado.",
                    icon: "success"
                });
                // Aquí puedes agregar la lógica para eliminar el registro
            }
        });
    });
});


// Script personalizado para abrir el modal al hacer clic en el botón de editar 

// Agrega un evento de clic a todos los botones de editar
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
$('#exampleModal').modal('hide')

});
});

// codigo que muestra una vista previa de la imagen seleccionada al AGREGAR un producto
document.getElementById('imagenProd').addEventListener('change', function(event) {
    var archivo = event.target.files[0];
    var vistaPreviaImagen = document.getElementById('vistaPreviaImagen');
    
    if (archivo) {
        var lector = new FileReader();
        lector.onload = function() {
            vistaPreviaImagen.src = lector.result;
            vistaPreviaImagen.style.display = 'block';
        }
        lector.readAsDataURL(archivo);
    } else {
        vistaPreviaImagen.src = '#';
        vistaPreviaImagen.style.display = 'none';
    }
});

// codigo que muestra una vista previa de la imagen seleccionada al AGREGAR un producto
document.getElementById('imagenProdEditar').addEventListener('change', function(event) {
    var archivo = event.target.files[0];
    var vistaPreviaImagen = document.getElementById('vistaPreviaImagenEditar');
    
    if (archivo) {
        var lector = new FileReader();
        lector.onload = function() {
            vistaPreviaImagen.src = lector.result;
            vistaPreviaImagen.style.display = 'block';
        }
        lector.readAsDataURL(archivo);
    } else {
        vistaPreviaImagen.src = '#';
        vistaPreviaImagen.style.display = 'none';
    }
});


