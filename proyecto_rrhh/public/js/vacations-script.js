$(document).ready(function() {
const table = $('#vacaciones').DataTable({
    language: {
        searchPlaceholder: "Escribí por cualquier criterio",
        "sProcessing":     "Cargando...",
        "sLengthMenu":     '<i class="fa-solid fa-filter"></i> &nbsp;Mostrar hasta&nbsp; _MENU_&nbsp; por página',
        "sZeroRecords":    "No se encontraron solicitudes según el criterio de búsqueda",
        "sEmptyTable":     "No hay solicitudes en el sistema.",
        "sInfo":           '<i class="fa-solid fa-hand"></i> &nbsp;Mostrando solicitudes del _START_ al _END_ de un total de _TOTAL_',
        "sInfoEmpty":      "No se muestra ninguna solicitud",
        "sInfoFiltered":   "(filtrado de un total de _MAX_)",
        "sInfoPostFix":    "",
        "sSearch":         '<i class="fas fa-search"></i> &nbsp;Buscar &nbsp;',
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     'Siguiente &nbsp;<i class="fa-solid fa-angles-right"></i>',
            "sPrevious": '<i class="fa-solid fa-angles-left"></i> &nbsp;Anterior'
        }
    },
    stateSave: true,
    columnDefs: [
        { targets: '_all', className: 'dt-center' },
        {
            targets: [0, 1, 2],
            render: function(data, type, row) {
                if (type === 'display' || type === 'filter') {
                    return moment(data).format('DD-MM-YYYY');
                }
                return data;
            }
        }
    ]
});

actualizarLista();

$(document).keydown(function(e) {
    if (e.which === 116) {
        e.preventDefault();
        actualizarLista();
    }
});

setInterval(actualizarLista, 300000); // Actualizar cada 5 minutos

$('.close, .btn-cancelar').click(function() {
    $('.modal').hide();
});

$(window).click(function(event) {
    if ($(event.target).hasClass('modal')) {
        $('.modal').hide();
    }
});

$('#formSolicitud').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: 'index.php?action=user/solicitarVacacion',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#modalSolicitud').hide();
                Swal.fire({
                    icon: 'success',
                    title: '¡Solicitud enviada!',
                    text: 'La estaremos revisando. Recibirás novedades en tu correo electrónico',
                    confirmButtonColor: '#4CAF50'
                }).then(() => {
                    actualizarLista();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Ocurrió un error al procesar la solicitud',
                    confirmButtonColor: '#9b59b6'
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al procesar la solicitud',
                confirmButtonColor: '#9b59b6'
            });
        }
    });
});
});

function actualizarLista() {
const btnActualizar = $('.btn-actualizar');
const iconoActualizar = btnActualizar.find('i');

btnActualizar.prop('disabled', true);
btnActualizar.addClass('loading');

$.ajax({
    url: 'index.php?action=user/obtenerVacacionesJSON',
    method: 'GET',
    dataType: 'json',
    success: function(vacaciones) {
        const table = $('#vacaciones').DataTable();
        
        table.clear();
        
        vacaciones.forEach(function(vacacion) {
            table.row.add([
                vacacion.fecha_solicitud,
                vacacion.fecha_inicio,
                vacacion.fecha_fin,
                vacacion.estado
            ]);
        });
        
        table.draw();
    },
    error: function(xhr, status, error) {
        Swal.fire({
            icon: 'error',
            title: 'Error al actualizar',
            text: 'No se pudo actualizar la lista. Por favor, intentá de nuevo',
            confirmButtonColor: '#9b59b6'
        });
        console.error('Error al actualizar:', error);
    },
    complete: function() {
        setTimeout(() => {
            btnActualizar.prop('disabled', false);
            btnActualizar.removeClass('loading');
        }, 500);
    }
});
}

function mostrarModalSolicitud() {
$('#formSolicitud')[0].reset();
$('#modalSolicitud').show();
}