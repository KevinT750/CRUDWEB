<?php
include("../config/conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Crear instancia de la clase Cls_DataConnection
    $db = new Cls_DataConnection();
    $conexion1 = $db->Fn_getConnect();

    $usuario = mysqli_real_escape_string($conexion1, $_POST['usuario']);
    $contrasena = mysqli_real_escape_string($conexion1, $_POST['contrasena']);

    $sql = "SELECT * FROM usuarios WHERE USUARIO='$usuario' AND CONTRASENA='$contrasena'";
    $result = mysqli_query($conexion1, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        header('Location: ../Vista/Principal.html'); 
    } else {
        header('Location: ../Vista/LoginError.html'); 
    }
    $conexion1->close();
}
?>
