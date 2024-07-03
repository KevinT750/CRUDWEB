<?php
// Incluir archivo de conexión u otras configuraciones necesarias
require_once "../config/conexion.php"; // Ajusta la ruta según tu estructura

// Instanciar la clase de conexión y obtener la conexión
$db = new Cls_DataConnection();
$conexion = $db->Fn_getConnect();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action'])) {
    $accion = $_GET['action'];

    switch ($accion) {
        case 'leer':
            mostrarUsuarios();
            break;
        default:
            echo 'Acción no válida';
            break;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action'])) {
    $accion = $_GET['action'];

    switch ($accion) {
        case 'crear':
            crearUsuario();
            break;
        case 'actualizar':
            actualizarUsuario();
            break;
        case 'eliminar':
            eliminarUsuario();
            break;
        default:
            echo 'Acción no válida';
            break;
    }
} else {
    echo 'Acceso denegado.';
}

function mostrarUsuarios() {
    global $conexion;
    
    // Preparar y ejecutar la llamada al procedimiento almacenado
    $sql = "CALL sp_crud_usuarios('leer', '', '', '', '', '', '')";
    $result = mysqli_query($conexion, $sql);

    if ($result) {
        // Construir la tabla HTML con los datos de los usuarios
        $table = '<table class="table table-striped">';
        $table .= '<thead><tr><th>Cédula</th><th>Nombre</th><th>Apellido</th><th>Fecha de Nacimiento</th><th>Usuario</th></tr></thead>';
        $table .= '<tbody>';
        while ($row = mysqli_fetch_assoc($result)) {
            $table .= '<tr>';
            $table .= '<td>' . htmlspecialchars($row['CEDULA']) . '</td>';
            $table .= '<td>' . htmlspecialchars($row['NOMBRE']) . '</td>';
            $table .= '<td>' . htmlspecialchars($row['APELLIDO']) . '</td>';
            $table .= '<td>' . htmlspecialchars($row['FECHA_NACIMIENTO']) . '</td>';
            $table .= '<td>' . htmlspecialchars($row['USUARIO']) . '</td>';
            $table .= '</tr>';
        }
        $table .= '</tbody></table>';

        echo $table;
    } else {
        echo 'Error al obtener usuarios: ' . mysqli_error($conexion);
    }

    mysqli_free_result($result);
}

function crearUsuario() {
    global $conexion;

    // Verificar si los datos esperados están presentes
    if (isset($_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['fecha_nacimiento'], $_POST['usuario'], $_POST['contrasena'])) {
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];

        // Preparar y ejecutar la llamada al procedimiento almacenado
        $sql = "CALL sp_crud_usuarios('crear', ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $cedula, $nombre, $apellido, $fecha_nacimiento, $usuario, $contrasena);

        if (mysqli_stmt_execute($stmt)) {
            echo 'Usuario creado exitosamente.';
        } else {
            echo 'Error al crear usuario: ' . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo 'Faltan datos requeridos para crear usuario.';
    }
}

function actualizarUsuario() {
    global $conexion;

    // Verificar si los datos esperados están presentes
    if (isset($_POST['cedula'], $_POST['nombre'], $_POST['apellido'], $_POST['fecha_nacimiento'], $_POST['usuario'], $_POST['contrasena'])) {
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];

        // Preparar y ejecutar la llamada al procedimiento almacenado
        $sql = "CALL sp_crud_usuarios('actualizar', ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $cedula, $nombre, $apellido, $fecha_nacimiento, $usuario, $contrasena);

        if (mysqli_stmt_execute($stmt)) {
            echo 'Usuario actualizado exitosamente.';
        } else {
            echo 'Error al actualizar usuario: ' . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo 'Faltan datos requeridos para actualizar usuario.';
    }
}

function eliminarUsuario() {
    global $conexion;

    // Verificar si los datos esperados están presentes
    if (isset($_POST['cedula'])) {
        $cedula = $_POST['cedula'];

        // Preparar y ejecutar la llamada al procedimiento almacenado
        $sql = "CALL sp_crud_usuarios('eliminar', ?, '', '', '', '', '')";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "s", $cedula);

        if (mysqli_stmt_execute($stmt)) {
            echo 'Usuario eliminado exitosamente.';
        } else {
            echo 'Error al eliminar usuario: ' . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo 'Falta la cédula del usuario a eliminar.';
    }
}

?>
