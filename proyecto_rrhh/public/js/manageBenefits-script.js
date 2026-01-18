window.mostrarModalAltaCategoria = function() {
    $('#modalAltaCategoria').show();
    limpiarFormulario('#formAltaCategoria');
};

window.mostrarModalAltaBeneficio = function() {
    $('#modalAltaBeneficio').show();
    limpiarFormulario('#formAltaBeneficio');
    cargarCategorias();
};

window.editarCategoria = function(id) {
    $.ajax({
        url: 'index.php?action=categoria/obtenerPorId',
        method: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success' && response.data) {
                const categoria = response.data;
                $('#mod_cat_id').val(categoria.id);
                $('#mod_cat_nombre').val(categoria.nombre);
                $('#mod_cat_descripcion').val(categoria.descripcion);
                $('#modalModificarCategoria').show();
            } else {
                Swal.fire('Error', response.message || 'No se pudo cargar la categoría', 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Error en la conexión', 'error');
        }
    });
};

window.editarBeneficio = function(id) {
    $.ajax({
        url: 'index.php?action=beneficio/obtenerPorId',
        method: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success' && response.data) {
                const beneficio = response.data;
                $('#mod_ben_id').val(beneficio.id);
                $('#mod_ben_nombre').val(beneficio.nombre);
                $('#mod_ben_descripcion').val(beneficio.descripcion);
                $('#mod_ben_descuento').val(beneficio.descuento);
                cargarCategorias(beneficio.categoria_id);
                $('#modalModificarBeneficio').show();
            } else {
                Swal.fire('Error', response.message || 'No se pudo cargar el beneficio', 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Error en la conexión', 'error');
        }
    });
};

window.eliminarCategoria = function(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción marcará la categoría como dada de baja",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, dar de baja',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'index.php?action=categoria/eliminarCategoria',
                method: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'success') {
                        Swal.fire('¡Dada de baja!', 'La categoría ha sido marcada como dada de baja.', 'success');
                        tablaCategorias.ajax.reload();
                        cargarCategorias();
                    } else {
                        Swal.fire('Error', response.message || 'No se pudo dar de baja la categoría', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Error en la conexión', 'error');
                }
            });
        }
    });
};

window.eliminarBeneficio = function(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'index.php?action=beneficio/eliminarBeneficio',
                method: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'success') {
                        Swal.fire('¡Eliminado!', 'El beneficio ha sido eliminado.', 'success');
                        tablaBeneficios.ajax.reload();
                    } else {
                        Swal.fire('Error', response.message || 'No se pudo eliminar el beneficio', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Error en la conexión', 'error');
                }
            });
        }
    });
};

window.limpiarFormulario = function(formId) {
    $(formId)[0].reset();
};

window.cargarCategorias = function(categoriaSeleccionada = null) {
    $.ajax({
        url: 'index.php?action=categoria/obtenerCategoriasJSON',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response && response.data) {
                const selects = ['#ben_categoria', '#mod_ben_categoria'];
                selects.forEach(selectId => {
                    const select = $(selectId);
                    select.empty();
                    select.append('<option value="">Seleccione una categoría</option>');
                    
                    response.data.forEach(categoria => {
                        const option = `<option value="${categoria.id}">${categoria.nombre}</option>`;
                        select.append(option);
                    });

                    if (categoriaSeleccionada) {
                        select.val(categoriaSeleccionada);
                    }
                });
            }
        },
        error: function() {
            console.error('Error al cargar categorías');
            Swal.fire('Error', 'No se pudieron cargar las categorías', 'error');
        }
    });
};

$(document).ready(function() {
    window.tablaCategorias = $('#categorias').DataTable({
        ajax: {
            url: 'index.php?action=categoria/obtenerCategoriasJSON',
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
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn-modificar tooltip" data-tooltip="Modificar" onclick="editarCategoria(${row.id})" class="btn-editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-baja tooltip" data-tooltip="Dar de baja" onclick="eliminarCategoria(${row.id})" class="btn-eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                }
            }
        ],
        language: {
            searchPlaceholder: "Escribí una categoría",
            "sProcessing": "Cargando...",
            "sLengthMenu": '<i class="fa-solid fa-filter"></i> &nbsp;Mostrar hasta&nbsp; _MENU_&nbsp; por página',
            "sZeroRecords": "No se encontraron categorías según el criterio de búsqueda",
            "sEmptyTable": "No hay categorías en el sistema. ¡Agregá una!",
            "sInfo": '<i class="fa-solid fa-layer-group"></i> &nbsp;Mostrando categorías del _START_ al _END_ de un total de _TOTAL_',
            "sInfoEmpty": "No se muestra ninguna categoría",
            "sInfoFiltered": "(filtrado de un total de _MAX_)",
            "sSearch": '<i class="fas fa-search"></i> &nbsp;Buscar &nbsp;',
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
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn-modificar tooltip" data-tooltip="Modificar" onclick="editarBeneficio(${row.id})" class="btn-editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-baja tooltip" data-tooltip="Dar de baja" onclick="eliminarBeneficio(${row.id})" class="btn-eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                }
            }
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

    $('.close, .btn-cancelar').on('click', function() {
        $('.modal').hide();
    });

    $(window).on('click', function(event) {
        if ($(event.target).hasClass('modal')) {
            $('.modal').hide();
        }
    });

    $('#formModificarCategoria').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        $.ajax({
            url: 'index.php?action=categoria/modificarCategoria',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    Swal.fire('¡Éxito!', 'Categoría modificada correctamente', 'success');
                    $('#modalModificarCategoria').hide();
                    tablaCategorias.ajax.reload();
                    cargarCategorias();
                } else {
                    Swal.fire('Error', response.message || 'Error al modificar la categoría', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Error en la conexión', 'error');
            }
        });
    });

    $('#formModificarBeneficio').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        $.ajax({
            url: 'index.php?action=beneficio/modificarBeneficio',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    Swal.fire('¡Éxito!', 'Beneficio modificado correctamente', 'success');
                    $('#modalModificarBeneficio').hide();
                    tablaBeneficios.ajax.reload();
                } else {
                    Swal.fire('Error', response.message || 'Error al modificar el beneficio', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Error en la conexión', 'error');
            }
        });
    });

    $('#formAltaCategoria').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        $.ajax({
            url: 'index.php?action=categoria/altaCategoria',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    Swal.fire('¡Éxito!', 'Categoría creada correctamente', 'success');
                    $('#modalAltaCategoria').hide();
                    tablaCategorias.ajax.reload();
                    cargarCategorias();
                    limpiarFormulario('#formAltaCategoria');
                } else {
                    Swal.fire('Error', response.message || 'Error al crear la categoría', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Error en la conexión', 'error');
            }
        });
    });

    $('#formAltaBeneficio').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        
        $.ajax({
            url: 'index.php?action=beneficio/altaBeneficio',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    Swal.fire('¡Éxito!', 'Beneficio creado correctamente', 'success');
                    $('#modalAltaBeneficio').hide();
                    tablaBeneficios.ajax.reload();
                    limpiarFormulario('#formAltaBeneficio');
                } else {
                    Swal.fire('Error', response.message || 'Error al crear el beneficio', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Error en la conexión', 'error');
            }
        });
    });

    cargarCategorias();
});