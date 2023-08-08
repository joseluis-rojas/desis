<?php
class Cconexion{
    function ConexionDB(){
        //incorporar los valores corespondientes en las variables
        $nombreServidor = "localhost";
        $usuario = "";
        $contrasena = "";
        $nombreBaseDatos = "VOTACION";
        $puerto = 1433;

        try {

            $conn = new PDO("sqlsrv:server=$nombreServidor,$puerto;database=$nombreBaseDatos", $usuario, $contrasena);

            // echo "Conexion exitosa en el servidor $nombreServidor";

        } catch (Exception $e) {
            echo "Ocurrió un error en la conexion. " . $e->getMessage();
        }

        return $conn;
    }
}
?>