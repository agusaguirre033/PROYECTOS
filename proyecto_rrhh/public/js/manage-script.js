$(document).ready(function() {
    const table = $('#empleados').DataTable({
        language: {
            searchPlaceholder: "Escribí por cualquier criterio",
            "sProcessing":     "Cargando...",
            "sLengthMenu":     '<i class="fa-solid fa-filter"></i> &nbsp;Mostrar hasta&nbsp; _MENU_&nbsp; por página',
            "sZeroRecords":    "No se encontraron empleados según el criterio de búsqueda",
            "sEmptyTable":     "No hay empleados en el sistema. ¡Agregá uno!",
            "sInfo":           '<i class="fa-solid fa-users-line"></i> &nbsp;Mostrando empleados del _START_ al _END_ de un total de _TOTAL_',
            "sInfoEmpty":      "No se muestra ningún empleado",
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
            }
        },
        stateSave: true,
        columnDefs: [
            {
                targets: '_all',
                className: 'dt-center'
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
    
    setInterval(actualizarLista, 300000);
});

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
            url: 'index.php?action=actualizarEmpleado',
            method: 'POST',
            data: $(this).serialize(),
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
                    title: 'Modificaste al empleado correctamente',
                })
                actualizarLista($('#vacaciones').DataTable());
            },
            error: function() {
                alert('Error al actualizar el empleado');
            }
        });
    });

function actualizarLista() {
const btnActualizar = $('.btn-actualizar');
const iconoActualizar = btnActualizar.find('i');

btnActualizar.prop('disabled', true);
btnActualizar.addClass('loading');

$.ajax({
    url: 'index.php?action=obtenerEmpleadosJSON',
    method: 'GET',
    dataType: 'json',
    success: function(empleados) {
        const table = $('#empleados').DataTable();
        
        table.clear();
        
        empleados.forEach(function(empleado) {
            const fechaNacimientoFormateada = moment(empleado.fecha_nacimiento).format('DD-MM-YYYY'); // Se formatea con Moment.js la fecha de nacimiento así es DÍA/MES/AÑO (observación del profe)
            table.row.add([
                empleado.dni,
                empleado.nombre,
                empleado.apellido,
                empleado.email,
                fechaNacimientoFormateada,
                empleado.area_nombre,
                `<button class="btn-modificar tooltip" data-tooltip="Modificar" onclick="mostrarModalModificar('${encodeURIComponent(empleado.dni)}', '${empleado.nombre.replace(/'/g, "\\'")}', '${empleado.apellido.replace(/'/g, "\\'")}', '${empleado.email}', '${empleado.fecha_nacimiento}', '${empleado.area_id}')"><i class="fa-solid fa-pen-to-square"></i></button>
                <button class="btn-baja tooltip" data-tooltip="Dar de baja" onclick="confirmarBaja('${encodeURIComponent(empleado.dni)}', '${empleado.nombre.replace(/'/g, "\\'")} ${empleado.apellido.replace(/'/g, "\\'")}', '${empleado.area_nombre.replace(/'/g, "\\'")}')"><i class="fa-solid fa-arrow-down"></i></button>`
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

function mostrarModalModificar(dni, nombre, apellido, email, fechaNacimiento, areaId) {
    $('#mod_dni').val(dni);
    $('#mod_nombre').val(nombre);
    $('#mod_apellido').val(apellido);
    $('#mod_email').val(email);
    $('#mod_fecha_nacimiento').val(fechaNacimiento);
    $('#mod_area_id').val(areaId);
    $('#modalModificar').show();
}

function confirmarBaja(dni, nombreCompleto, area) {
    $('#nombreEmpleadoBaja').text(nombreCompleto);
    $('#areaEmpleadoBaja').text(area);
    $('#confirmarBajaBtn').data('dni', dni);
    $('#modalBaja').show();
}

$('#confirmarBajaBtn').click(function() {
const dni = $(this).data('dni');

$.ajax({
    url: 'index.php?action=eliminarEmpleado',
    method: 'GET',
    data: {
        dni: dni
    },
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
            title: 'Diste de baja al empleado correctamente',
        })
        actualizarLista($('#vacaciones').DataTable());
    },
    error: function() {
        alert('Error al dar de baja al empleado');
    }
});
});

$('#formAlta').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: 'index.php?action=altaEmpleado',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#modalAlta').hide();
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
                    title: 'Diste de alta al empleado correctamente',
                })
                actualizarLista($('#vacaciones').DataTable());
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
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