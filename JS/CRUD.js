const urlParams = new URLSearchParams(window.location.search);
const action = urlParams.get('action');
const crudContent = document.getElementById('crudContent');

if (action) {
    switch (action) {
        case 'crear':
            CrearUsuarios();
            break;
        case 'leer':
            verUsuarios();
            break;
        case 'actualizar':
            ActualizarUsuarios();
            break;
        case 'eliminar':
            eliminarUsuarios();
            break;
        default:
            break;
    }
}


function CrearUsuarios() {
    crudContent.innerHTML = `
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">Crear Usuario</h2>
                <form id="crearUsuarioForm">
                    <div class="mb-3">
                        <label for="cedula" class="form-label">Cédula:</label>
                        <input type="text" id="cedula" name="cedula" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido:</label>
                        <input type="text" id="apellido" name="apellido" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento:</label>
                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario:</label>
                        <input type="text" id="usuario" name="usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña:</label>
                        <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Crear</button>
                </form>
            </div>
        </div>
    `;

    document.getElementById('crearUsuarioForm').addEventListener('submit', function(event) {
        event.preventDefault(); 
        const formData = new FormData(this);

        $.ajax({
            url: 'http://localhost:8080/WEBDB/JS/CRUD.php?action=crear',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response); // Mostrar mensaje de éxito
                verUsuarios(); // Mostrar nuevamente la lista de usuarios actualizada
            },
            error: function(xhr, status, error) {
                console.error('Error al crear usuario:', error);
                alert('Error al crear usuario. Consulta la consola para más detalles.');
            }
        });
    });
}

function verUsuarios() {
    crudContent.innerHTML = `
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">Mostrar Usuarios</h2>
                <div id="userTable">
                    <!-- Aquí se cargará dinámicamente la tabla de usuarios -->
                </div>
            </div>
        </div>
    `;

    // Realizar la solicitud AJAX para obtener los usuarios
    $.ajax({
        url: 'http://localhost:8080/WEBDB/JS/CRUD.php?action=leer',
        type: 'GET',
        success: function(response) {
            $('#userTable').html(response); // Insertar la tabla de usuarios en el contenedor
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener usuarios:', error);
            alert('Error al obtener usuarios. Consulta la consola para más detalles.');
        }
    });
}

function ActualizarUsuarios() {
    crudContent.innerHTML = `
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">Actualizar Usuario</h2>
                <form id="actualizarUsuarioForm">
                    <div class="mb-3">
                        <label for="cedulaActualizar" class="form-label">Ingrese la cédula del usuario:</label>
                        <input type="text" id="cedulaActualizar" name="cedula" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Buscar</button>
                </form>
                <div id="formularioActualizar">
                    <!-- Aquí se mostrará el formulario para actualizar -->
                </div>
            </div>
        </div>
    `;

    // Capturar el evento submit del formulario
    document.getElementById('actualizarUsuarioForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el envío por defecto del formulario
        const formData = new FormData(this);

        // Realizar la solicitud AJAX para buscar el usuario
        $.ajax({
            url: 'http://localhost:8080/WEBDB/JS/CRUD.php?action=buscar',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#formularioActualizar').html(response); // Mostrar el formulario de actualización
                bindActualizarForm(); // Vincular el formulario de actualización con su funcionalidad
            },
            error: function(xhr, status, error) {
                console.error('Error al buscar usuario:', error);
                alert('Error al buscar usuario. Consulta la consola para más detalles.');
            }
        });
    });

    // Función para vincular el formulario de actualización con su funcionalidad
    function bindActualizarForm() {
        $('#formularioActualizar').on('submit', '#formActualizarUsuario', function(event) {
            event.preventDefault(); // Prevenir el envío por defecto del formulario
            const formData = new FormData(this);

            // Realizar la solicitud AJAX para actualizar el usuario
            $.ajax({
                url: 'http://localhost:8080/WEBDB/JS/CRUD.php?action=actualizar',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert(response); // Mostrar mensaje de éxito
                    verUsuarios(); // Mostrar nuevamente la lista de usuarios actualizada
                },
                error: function(xhr, status, error) {
                    console.error('Error al actualizar usuario:', error);
                    alert('Error al actualizar usuario. Consulta la consola para más detalles.');
                }
            });
        });
    }
}


function eliminarUsuarios() {
    crudContent.innerHTML = `
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">Eliminar Usuario</h2>
                <form id="eliminarUsuarioForm">
                    <div class="mb-3">
                        <label for="cedulaEliminar" class="form-label">Ingrese la cédula del usuario:</label>
                        <input type="text" id="cedulaEliminar" name="cedula" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Eliminar</button>
                </form>
            </div>
        </div>
    `;

    // Capturar el evento submit del formulario
    document.getElementById('eliminarUsuarioForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevenir el envío por defecto del formulario
        const formData = new FormData(this);

        
        $.ajax({
            url: 'http://localhost:8080/WEBDB/JS/CRUD.php?action=eliminar',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response); 
                verUsuarios(); 
            },
            error: function(xhr, status, error) {
                console.error('Error al eliminar usuario:', error);
                alert('Error al eliminar usuario. Consulta la consola para más detalles.');
            }
        });
    });
}
