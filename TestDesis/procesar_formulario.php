<?php
// Importar la clase Cconexion 
require_once 'conexion.php';

// Crea una instancia de la clase Cconexion
$conexion = new Cconexion();

// Llama al método ConexionDB usando la instancia
$conn = $conexion->ConexionDB();

$queryRegion = "SELECT * FROM REGION";
$stmt = $conn->query($queryRegion);
$regiones = $stmt->fetchAll(PDO::FETCH_OBJ);
$queryCandidato = "SELECT * FROM CANDIDATO";
$stmt = $conn->query($queryCandidato);
$candidatos = $stmt->fetchAll(PDO::FETCH_OBJ);

?>
<?php

function validarRut($rut)
{
    // Retorna true si es válido, false en caso contrario
    $rut = preg_replace('/[^k0-9]/i', '', $rut); // Eliminar caracteres no válidos
    $dv = substr($rut, -1); // Obtener el dígito verificador
    $rut = substr($rut, 0, -1); // Obtener el número del RUT

    $suma = 0;
    $multiplo = 2;

    for ($i = strlen($rut) - 1; $i >= 0; $i--) {
        $suma += $rut[$i] * $multiplo;
        $multiplo = ($multiplo == 7) ? 2 : $multiplo + 1;
    }

    $resultado = $suma % 11;
    $dvCalculado = 11 - $resultado;

    if ($dvCalculado == 10) {
        $dvCalculado = 'K';
    } elseif ($dvCalculado == 11) {
        $dvCalculado = 0;
    }

    return ($dv == $dvCalculado);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $alias = $_POST['alias'];
    $rut = $_POST['rut'];
    $email = $_POST['email'];
    $region = $_POST['region'];
    $comuna = $_POST['comuna'];
    $candidato = $_POST['candidato'];
    $web = isset($_POST['web']) ? 1 : 0;
    $tv = isset($_POST['tv']) ? 1 : 0;
    $redes = isset($_POST['redes']) ? 1 : 0;
    $amigo = isset($_POST['amigo']) ? 1 : 0;

    $errors = [];

    // Validar el nombre
    if (empty($_POST['nombre'])) {
        $errors[] = "El campo Nombre y Apellido no puede quedar en blanco.";   
    }
    $alias = $_POST['alias'];
    if (strlen($alias) < 5 || !preg_match('/^[a-zA-Z0-9]+$/', $alias)) {
        $errors[] = "El Alias debe tener al menos 5 caracteres y contener letras y números.";
    }
    $rut = $_POST['rut'];
    if (validarRut($rut)) {

    } else {
        $errors[] = "El RUT no es válido.";
    }

    if (empty($errors)) {
        // Inserción en la base de datos
        try {
            // Importar la clase Cconexion
            require_once 'conexion.php';

            // Obtén los valores del formulario
            $nombre = $_POST['nombre'];
            $alias = $_POST['alias'];
            $rut = $_POST['rut'];
            $email = $_POST['email'];
            $region = $_POST['region'];
            $comuna = $_POST['comuna'];
            $candidato = $_POST['candidato'];
            $web = isset($_POST['web']) ? 1 : 0;
            $tv = isset($_POST['tv']) ? 1 : 0;
            $redes = isset($_POST['redes']) ? 1 : 0;
            $amigo = isset($_POST['amigo']) ? 1 : 0;
           
            $conexion = new Cconexion();
       
            $conn = $conexion->ConexionDB();

            $queryVerificar = "SELECT COUNT(*) AS existe FROM REGISTRO WHERE rut = '$rut'";
            $result = $conn->query($queryVerificar);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            if ($row['existe'] > 0) {
                echo "<div class='form-container'>";
                echo "El RUT ingresado ya ha sido registrado.";
                echo "</div>";
            } else {                
                $queryVotacion = "INSERT INTO REGISTRO (nombre_apellido, alias, rut, email, region, comuna, candidato, web, tv, redes, amigo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($queryVotacion);
                $stmt->bindParam(1, $nombre);
                $stmt->bindParam(2, $alias);
                $stmt->bindParam(3, $rut);
                $stmt->bindParam(4, $email);
                $stmt->bindParam(5, $region);
                $stmt->bindParam(6, $comuna);
                $stmt->bindParam(7, $candidato);
                $stmt->bindParam(8, $web);
                $stmt->bindParam(9, $tv);
                $stmt->bindParam(10, $redes);
                $stmt->bindParam(11, $amigo);

                if ($stmt->execute()) {
                    echo "<div class='form-container'>";
                    echo "Datos almacenados correctamente en la base de datos.";
                    echo "</div>";
                    // Redirige al usuario de nuevo a la misma página
                    header("Location: index.php");
                    exit(); // Asegura que el código posterior no se ejecute después de la redirección

                } else {
                    echo "<div class='form-container'>";
                    echo "Ocurrió un error al almacenar los datos en la base de datos.";
                    echo "</div>";
                }
            }
        } catch (Exception $e) {
            echo "<div class='form-container'>";
            echo "Ocurrió un error al almacenar los datos en la base de datos. " . $e->getMessage();
            echo "</div>";
        }


    } else {
        echo "<div class='form-container'>";
        foreach ($errors as $error) {           
           
            echo  "<p class='error-message'> - " . $error . "</p>";
            
        }
        echo "</div><br>";
    }
}
?>