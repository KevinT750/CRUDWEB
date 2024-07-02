<?php 
require_once "global.php";

class Cls_DataConnection
{
    function Fn_getConnect()
    {
        if (!($conexion1 = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME)))
        {
            echo "Error Conectando la base de Datos";
            exit();
        }
        return $conexion1;
    }
    
    function ejecutarConsultaSP($sql)
    { 
        $Cn = $this->Fn_getConnect();
        $query = $Cn->query($sql);
        $Cn->close();
        return $query;            
    }
}
?>
