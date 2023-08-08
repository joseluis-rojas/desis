<?php
class Cconexion{
    function ConexionDB(){
        $nombreServidor = "localhost";
        $usuario = "intphar";
        $contrasena = "q1w2e3.q";
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