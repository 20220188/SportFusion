// Constante para completar la ruta de la API.
const PRODUCTO_API = 'services/admin/producto.php';
const PEDIDO_API = 'services/admin/pedido.php';

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Constante para obtener el número de horas.
    const HOUR = new Date().getHours();
    // Se define una variable para guardar un saludo.
    let greeting = '';
    // Dependiendo del número de horas transcurridas en el día, se asigna un saludo para el usuario.
    if (HOUR < 12) {
        greeting = 'Buenos días';
    } else if (HOUR < 19) {
        greeting = 'Buenas tardes';
    } else if (HOUR <= 23) {
        greeting = 'Buenas noches';
    }
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = `${greeting}, bienvenido`;
    // Llamada a la funciones que generan los gráficos en la página web.
    graficoBarrasValoraciones();
    graficoBarrasProductosTopVendidos();
    graficoPastelCategorias();
});

/*
*   Función asíncrona para mostrar un gráfico de barras con la cantidad de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const graficoBarrasValoraciones = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(PEDIDO_API, 'ValoracionesProductos');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let productos = [];
        let valoraciones = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            productos.push(row.nombre_producto);
            valoraciones.push(row.promedio);
        });
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart1', productos, valoraciones, 'Valoracion media', 'Productos mejor valorados');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.error);
    }
}


const graficoBarrasProductosTopVendidos = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(PRODUCTO_API, 'ProductosTopVendidos');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let productos = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            productos.push(row.nombre_producto);
            cantidades.push(row.total);
        });
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart3', productos, cantidades, 'Productos', 'Productos más vendidos');
    } else {
        document.getElementById('chart3').remove();
        console.log(DATA.error);
    }
}

/*
*   Función asíncrona para mostrar un gráfico de pastel con el porcentaje de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const graficoPastelCategorias = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(PRODUCTO_API, 'cantidadProductosCategoria');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let categorias = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            categorias.push(row.nombre_categoria);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función para generar y mostrar un gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chart2', categorias, cantidades, 'Cantidad de productos por categoría');
    } else {
        document.getElementById('chart2').remove();
        console.log(DATA.error);
    }
}

