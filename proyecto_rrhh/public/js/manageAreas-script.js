$(document).ready(function() {
    const table = $('#areas').DataTable({
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
                            columns: [0, 1]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> &nbsp;PDF',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> &nbsp;Imprimir',
                        exportOptions: {
                            columns: [0, 1]
                        }
                    }
                ]
            }
        ],
        language: {
            searchPlaceholder: "Escribí un nombre",
            "sProcessing": "Cargando...",
            "sLengthMenu": '<i class="fa-solid fa-filter"></i>&nbsp;Mostrar hasta&nbsp; _MENU_&nbsp; por página',
            "sZeroRecords": "No se encontraron áreas según el criterio de búsqueda",
            "sEmptyTable": "No hay áreas en el sistema. ¡Agregá una!",
            "sInfo": '<i class="fa-solid fa-building"></i>&nbsp;Mostrando áreas del _START_ al _END_ de un total de _TOTAL_',
            "sInfoEmpty": "No se muestra ninguna área",
            "sInfoFiltered": "(filtrado de un total de _MAX_)",
            "sSearch": '<i class="fas fa-search"></i>&nbsp;Buscar &nbsp;',
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": 'Siguiente &nbsp;<i class="fa-solid fa-angles-right"></i>',
                "sPrevious": '<i class="fa-solid fa-angles-left"></i>&nbsp;Anterior'
            }
        },
        stateSave: true,
        columnDefs: [{
            targets: '_all',
            className: 'dt-center'
        }]
    });

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

    actualizarLista();

    $(document).keydown(function(e) {
        if (e.which === 116) {
            e.preventDefault();
            actualizarLista();
        }
    });

    setInterval(actualizarLista, 300000);

    $('.close, .btn-cancelar').click(function() {
        $('.modal').hide();
    });

    $(window).click(function(event) {
        if ($(event.target).hasClass('modal')) {
            $('.modal').hide();
        }
    });

    $('#formModificar').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'index.php?action=actualizarArea',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                $('.modal').hide();
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
                    title: 'Modificaste el área correctamente',
                })
                actualizarLista($('#vacaciones').DataTable());
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al actualizar el área',
                    confirmButtonColor: '#9b59b6'
                });
            }
        });
    });

    $('#formAlta').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: 'index.php?action=altaArea',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                $('.modal').hide();
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
                    title: 'Diste de alta a la área correctamente.',
                })
                actualizarLista($('#vacaciones').DataTable());
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
        url: 'index.php?action=obtenerAreasJSON',
        method: 'GET',
        dataType: 'json',
        success: function(areas) {
            const table = $('#areas').DataTable();
            
            table.clear();
            
            areas.forEach(function(area) {
                table.row.add([
                    area.id,
                    area.nombre,
                    `<button class="btn-modificar tooltip" data-tooltip="Modificar" onclick="mostrarModalModificar('${area.id}', '${area.nombre.replace(/'/g, "\\'")}')">
                        <i class="fa-solid fa-pen-to-square"></i>
                     </button>
                     <button class="btn-baja tooltip" data-tooltip="Dar de baja" onclick="confirmarBaja('${area.id}', '${area.nombre.replace(/'/g, "\\'")}')">
                        <i class="fa-solid fa-arrow-down"></i>
                     </button>`
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

function mostrarModalAlta() {
    $('#formAlta')[0].reset();
    $('.validation-message').hide();
    $('#modalAlta').show();
}

function mostrarModalModificar(id, nombre) {
    $('#mod_id').val(id);
    $('#mod_nombre').val(nombre);
    $('#modalModificar').show();
}

function confirmarBaja(id, nombre) {
    $('#nombreAreaBaja').text(nombre);
    $('#confirmarBajaBtn').data('id', id);
    $('#modalBaja').show();
}

$('#confirmarBajaBtn').click(function() {
    const id = $(this).data('id');
    
    $.ajax({
        url: 'index.php?action=eliminarArea',
        method: 'GET',
        data: { id: id },
        success: function(response) {
            $('.modal').hide();
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
                title: 'Diste de baja a la área correctamente',
            })
            actualizarLista($('#vacaciones').DataTable());
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al dar de baja el área',
                confirmButtonColor: '#9b59b6'
            });
        }
    });
});