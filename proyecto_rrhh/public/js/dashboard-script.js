// Función para mostrar la precarga y cuando cargen los recursos se muestre la página
window.addEventListener('load', function() {
    document.querySelector('#precarga').style.opacity = '0';
    setTimeout(function() {
        document.querySelector('#precarga').style.display = 'none';
        document.querySelector('.container').style.opacity = '1';
        document.querySelector('.container').style.transform = 'scale(1)';
    }, 600);
});

// Menú desplegable
const userProfile = document.getElementById('userProfile');
const profileDropdown = document.getElementById('profileDropdown');
 let timeoutId;

function showDropdown() {
    clearTimeout(timeoutId);
    profileDropdown.style.display = 'block';
}

function hideDropdown() {
    timeoutId = setTimeout(() => {
        profileDropdown.style.display = 'none';
    }, 300);
}

// Eventos para mostrar/ocultar el menú
userProfile.addEventListener('mouseenter', showDropdown);
userProfile.addEventListener('mouseleave', hideDropdown);
userProfile.addEventListener('click', (e) => {
    e.stopPropagation();
    if (profileDropdown.style.display === 'block') {
        profileDropdown.style.display = 'none';
    } else {
        showDropdown();
    }
});

profileDropdown.addEventListener('mouseenter', showDropdown);
profileDropdown.addEventListener('mouseleave', hideDropdown);
profileDropdown.addEventListener('click', (e) => e.stopPropagation());
// Cierra el menú al hacer clic afuera
document.addEventListener('click', () => {
    profileDropdown.style.display = 'none';
});

document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.header');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
});

function editarPerfil() {
    Swal.fire({
        title: 'Cargando tu perfil...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('?action=obtenerPerfil', {
        method: 'GET',
        headers: {
            'Cache-Control': 'no-cache'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        return response.json();
    })
    .then(response => {
        if (response.success) {
            mostrarModalEdicion(response.data);
        } else {
            throw new Error(response.message || 'Error al cargar los datos');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'No se pudieron cargar los datos del usuario'
        });
    });
}

function mostrarModalEdicion(userData) {
    Swal.fire({
        title: '<i class="fas fa-user-edit"></i> Editar perfil',
        html: `
            <form id="formEditarPerfil">
                <input type="hidden" id="dni" name="dni" value="${userData.dni || ''}">
                
                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-user-large"></i>
                        Nombre
                    </label>
                    <input type="text" class="form-control" id="nombre" name="nombre"
                           value="${userData.nombre || ''}" required placeholder="Ingrese el nombre">
                </div>
                
                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-user-group"></i>
                        Apellido(s)
                    </label>
                    <input type="text" class="form-control" id="apellido" name="apellido"
                           value="${userData.apellido || ''}" required placeholder="Ingrese el apellido">
                </div>
                
                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-envelope"></i>
                        Correo electrónico
                    </label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="${userData.email || ''}" required placeholder="correo@ejemplo.com">
                </div>
                
                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-calendar"></i>
                        Fecha de nacimiento
                    </label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                           value="${userData.fecha_nacimiento || ''}" required>
                </div>

                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-money-bills"></i>
                        Sueldo
                    </label>
                    <input type="text" class="form-control" id="sueldo" name="sueldo"
                           value="${userData.sueldo || ''}" disabled>
                </div>
            </form>
        `,
        customClass: {
            container: 'modal-container',
            popup: 'modal-content',
            title: 'modal-title',
            confirmButton: 'btn-confirmar',
            cancelButton: 'btn-cancelar',
            actions: 'modal-actions'
        },
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-save"></i> Guardar',
        cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
        focusConfirm: false,
        buttonsStyling: false,
        preConfirm: () => {
            const form = document.getElementById('formEditarPerfil');
            if (!form.checkValidity()) {
                form.reportValidity();
                return false;
            }
            const formData = new FormData(form);
           
            return fetch('?action=actualizarPerfil', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message);
                }
                return data;
            })
            .catch(error => {
                Swal.showValidationMessage(error.message);
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.reload();
        }
    });
}