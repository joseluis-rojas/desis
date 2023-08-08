<?php
require_once 'conexion.php';
// Obtener el ID de la región seleccionada desde la solicitud POST
$regionId = $_POST['regionId'];

// Aquí deberías realizar la lógica para obtener las comunas de la región desde la base de datos
// Supongamos que $comunas es un array con las comunas de la región


// Crea una instancia de la clase Cconexion
$conexion = new Cconexion();

// Llama al método ConexionDB usando la instancia
$conn = $conexion->ConexionDB();

// Ahora puedes utilizar la variable $conn para tus operaciones de base de datos

$queryComuna = "SELECT * FROM COMUNA where id_region= $regionId";
$stmt = $conn->query($queryComuna);
$comunas = $stmt->fetchAll(PDO::FETCH_OBJ);


// Construir opciones de comunas
$options = '<option value="">Selecciona una comuna</option>';
foreach ($comunas as $comuna) {
    $options .= "<option value='{$comuna->id}'>{$comuna->nombre}</option>";
}

// Devolver opciones de comunas como respuesta AJAX
echo $options;
?>
