window.limpiarFormulario = function(formId) {
    $(formId)[0].reset();
};

window.tablaBeneficios = $('#beneficios').DataTable({
ajax: {
    url: 'index.php?action=beneficio/obtenerBeneficiosJSON',
    dataSrc: 'data',
    error: function(xhr, error, thrown) {
        console.error('Error en DataTable:', error);
        Swal.fire('Error', 'No se pudieron cargar los datos', 'error');
    }
},
columns: [
    { data: 'id' },
    { data: 'nombre' },
    { data: 'descripcion' },
    { 
        data: 'descuento',
        render: function(data) {
            return data + '%';
        }
    },
    { data: 'categoria_nombre' },
],
language: {
    searchPlaceholder: "Escribí un beneficio",
    "sProcessing": "Cargando...",
    "sLengthMenu": '<i class="fa-solid fa-filter"></i> &nbsp;Mostrar hasta&nbsp; _MENU_&nbsp; por página',
    "sZeroRecords": "No se encontraron beneficios según el criterio de búsqueda",
    "sEmptyTable": "No hay beneficios en el sistema. ¡Agregá una!",
    "sInfo": '<i class="fa-solid fa-tag"></i> &nbsp;Mostrando beneficios del _START_ al _END_ de un total de _TOTAL_',
    "sInfoEmpty": "No se muestra ninguna categoría",
    "sInfoFiltered": "(filtrado de un total de _MAX_)",
    "sSearch": '<i class="fas fa-search"></i>&nbsp;Buscar &nbsp;',
    "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": 'Siguiente &nbsp;<i class="fa-solid fa-angles-right"></i>',
        "sPrevious": '<i class="fa-solid fa-angles-left"></i> &nbsp;Anterior'
    }
},
stateSave: true,
columnDefs: [{
    targets: '_all',
    className: 'dt-center'
}]
});