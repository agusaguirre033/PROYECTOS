$(document).ready(function() {
    $('.btn-actualizar').on('click', function() {
        actualizarLista($('#vacaciones').DataTable());
    });

    const table = $('#vacaciones').DataTable({
        processing: true,
        dom: '<"top"lfB>rt<"bottom"ip>',
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
        buttons: [
            {
                extend: 'collection',
                text: '<i class="fas fa-file-export"></i> &nbsp;Exportar a',
                className: 'btn-exportar',
                buttons: [
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> &nbsp;CSV',
                        exportOptions: {
                            columns: [0,1,2,3,4,5]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> &nbsp;PDF',
                        exportOptions: {
                            columns: [0,1,2,3,4,5]
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> &nbsp;Imprimir',
                        exportOptions: {
                            columns: [0,1,2,3,4,5]
                        }
                    }
                ]
            }
        ],
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
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            buttons: {
                collection: 'Opciones de exportación'
            }
        },
        stateSave: true,
        processing: true,
        columnDefs: [
            { targets: '_all', className: 'dt-center' },
            {
                targets: [3, 4], 
                render: function(data, type, row) {
                    if (type === 'display' || type === 'filter') {
                        return moment(data).format('DD-MM-YYYY');
                    }
                    return data;
                }
            },
            {
                targets: 5,
                render: function(data, type, row) {
                    if (type === 'display') {
                        let backgroundColor, textColor;
                        switch(data) {
                            case 'Aprobado':
                                backgroundColor = '#4CAF50';
                                textColor = '#FFFFFF';
                                break;
                            case 'Pendiente':
                                backgroundColor = '#FFC107';
                                textColor = '#000000';
                                break;
                            case 'Rechazado':
                                backgroundColor = '#F44336';
                                textColor = '#FFFFFF';
                                break;
                            default:
                                backgroundColor = '#E0E0E0';
                                textColor = '#000000';
                        }
                        
                        let html = `<div style="display: flex; justify-content: center; align-items: center; gap: 10px;">`;
                        
                        // Si es Rechazado, hacemos el span clicable
                        if (data === 'Rechazado') {
                            html += `
                                <span 
                                    onclick="mostrarMotivo('${row.motivo_rechazo || 'No se proporcionó motivo'}')"
                                    style="
                                        background-color: ${backgroundColor};
                                        color: ${textColor};
                                        padding: 5px 10px;
                                        border-radius: 4px;
                                        display: inline-block;
                                        font-weight: 500;
                                        cursor: pointer;
                                        text-decoration: none;
                                    ">${data} <i class="fas fa-circle-info" style="margin-left: 5px;"></i></span>`;
                        } else {
                            html += `
                                <span style="
                                    background-color: ${backgroundColor};
                                    color: ${textColor};
                                    padding: 5px 10px;
                                    border-radius: 4px;
                                    display: inline-block;
                                    font-weight: 500;
                                ">${data}</span>`;
                        }
                        
                        html += '</div>';
                        return html;
                    }
                    return data;
                }
            }
        ]
    });
    
    actualizarLista(table);

    $('.btn-exportar').css({
        'background-color': '#f8f9fa',
        'border': '1px solid #ddd',
        'padding': '5px 10px',
        'border-radius': '4px',
        'margin-right': '10px',
        'margin-left': '15px',  
        'display': 'inline-flex',
        'align-items': 'center', 
        'position': 'relative',
        'top': '-5px'           
    });
});



function actualizarLista(table) {
const btnActualizar = $('.btn-actualizar');
const iconoActualizar = btnActualizar.find('i');

btnActualizar.prop('disabled', true);
btnActualizar.addClass('loading');

$.ajax({
    url: 'index.php?action=obtenerVacacionesJSON',
    type: 'GET',
    dataType: 'json',
    success: function(vacaciones) {
        table.clear();
        vacaciones.forEach(function(vacacion) {
            table.row.add({
                "0": vacacion.id,
                "1": vacacion.nombre,
                "2": vacacion.apellido,
                "3": vacacion.fecha_inicio,
                "4": vacacion.fecha_fin,
                "5": vacacion.estado,
                "6": `<button class="btn-alta tooltip" data-tooltip="Aprobar" onclick="aprobarVacacion(${vacacion.id})">
                        <i class="fas fa-check"></i>
                    </button>
                    <button class="btn-baja tooltip" data-tooltip="Rechazar" onclick="rechazarVacacion(${vacacion.id})">
                        <i class="fas fa-times"></i>
                    </button>`,
                "motivo_rechazo": vacacion.motivo_rechazo
            });
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

function mostrarMotivo(motivo) {
Swal.fire({
    title: 'Motivo del rechazo',
    text: motivo,
    icon: 'info',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Cerrar'
});
}

function aprobarVacacion(id) {
    Swal.fire({
        title: '¿Aprobar solicitud de vacaciones?',
        text: 'El empleado será notificado por correo electrónico',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aprobar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'index.php?action=admin/aprobarVacacion&id=' + id,
                type: 'POST',
                success: function(response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    background: '#4CAF50',
                    color: '#ffffff',
                    iconColor: '#ffffff',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
                
                Toast.fire({
                    icon: 'success',
                    title: '¡Solicitud aprobada correctamente! Se notificó al empleado',
                })
                actualizarLista($('#vacaciones').DataTable());
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ocurrió un error',
                        text: 'No se pudo aprobar la solicitud',
                        confirmButtonColor: '#9b59b6'
                    });
                }
            });
        }
    });
}

function rechazarVacacion(id) {
    Swal.fire({
        title: '¿Rechazar solicitud de vacaciones?',
        text: '',
        input: 'textarea',
        inputPlaceholder: 'Escribí el motivo de rechazo (opcional)',
        inputAttributes: {
            'aria-label': 'Motivo del rechazo'
        },
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Rechazar',
        cancelButtonText: 'Cancelar',
        inputValidator: (value) => {
            return null;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'index.php?action=admin/rechazarVacacion&id=' + id,
                type: 'POST',
                data: {
                    motivo: result.value || ''
                },
                success: function(response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    background: '#4CAF50',
                    color: '#ffffff',
                    iconColor: '#ffffff',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
                
                Toast.fire({
                    icon: 'success',
                    title: '¡Solicitud rechazada correctamente! Se notificó al empleado',
                })
                actualizarLista($('#vacaciones').DataTable());
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ocurrió un error',
                        text: 'No se pudo rechazar la solicitud',
                        confirmButtonColor: '#9b59b6'
                    });
                }
            });
        }
    });
}


    function mostrarModalSolicitud() {
        document.getElementById("modalSolicitud").style.display = "block";
    }

    var closeButtons = document.getElementsByClassName("close");
    for (var i = 0; i < closeButtons.length; i++) {
        closeButtons[i].addEventListener("click", function() {
            this.parentElement.parentElement.style.display = "none";
        });
    }

    window.addEventListener("click", function(event) {
        var modals = document.getElementsByClassName("modal");
        for (var i = 0; i < modals.length; i++) {
            if (event.target == modals[i]) {
                modals[i].style.display = "none";
            }
        }
    });