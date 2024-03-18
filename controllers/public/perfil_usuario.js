// Función para manejar la acción de enviar el formulario
document.getElementById('editForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita que el formulario se envíe

    // Obtener los valores de los campos
    var nombre = document.getElementById('nombre').value;
    var direccion = document.getElementById('direccion').value;
    var correo = document.getElementById('correo').value;
    var telefono = document.getElementById('telefono').value;

    // Aquí puedes realizar acciones adicionales, como enviar los datos a un servidor

    // Cerrar el modal
    $('#myModal').modal('hide');
});

// Función para mostrar la vista previa de la imagen seleccionada
document.getElementById('profileImage').addEventListener('change', function(event) {
    var preview = document.getElementById('preview');
    var file = event.target.files[0];
    var reader = new FileReader();

    reader.onload = function(event) {
        preview.src = event.target.result;
    };

    reader.readAsDataURL(file);
});