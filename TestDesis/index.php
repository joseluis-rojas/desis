<?php
// Importa la clase Cconexion si no lo has hecho
require_once 'procesar_formulario.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Formulario</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">  
</head>

<body>
    <div class="form-container">
        <br><br>
        <div class="form-header">
            <h1>FORMULARIO DE VOTACIÓN:</h1>
        </div>
        <form action="index.php" method="post" >
            <div class="form-group">
                <label for="nombre">Nombre y Apellido</label>
                <input type="text" id="nombre" name="nombre">  
                <br><br>
            </div>
            <label for="alias">Alias:</label>
            <input type="text" id="alias" name="alias"><br><br>

            <label for="rut">RUT:</label>
            <input type="text" id="rut" name="rut"><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br><br>

            <label for="region">Región:</label>
            <select id="region" name="region">
                <option value="">Selecciona una region</option>
                <?php foreach ($regiones as $fila): ?>
                    <option value="<?php echo $fila->id; ?>"><?php echo $fila->nombre; ?></option>
                <?php endforeach; ?>
                <!-- Opciones de regiones -->
            </select><br><br>

            <label for="comuna">Comuna:</label>
            <select id="comuna" name="comuna">
                <option value="">Selecciona una comuna</option>
                <!-- Opciones de comunas -->
            </select><br><br>

            <label for="candidato">Candidato:</label>
            <select id="candidato" name="candidato">
                <option value="">Selecciona un candidato</option>
                <?php foreach ($candidatos as $fila): ?>
                    <option value="<?php echo $fila->id; ?>"><?php echo $fila->candidato; ?></option>
                <?php endforeach; ?>
                <!-- Opciones de regiones -->
            </select><br><br>
            <div class="checkbox-group">
                <label for="nosotros">Como se enteró de Nosotros:</label>
                <input type="checkbox" id="web" name="web">
                <label for="web">Web</label>
                <input type="checkbox" id="tv" name="tv">
                <label for="tv">TV</label>
                <input type="checkbox" id="redes" name="redes">
                <label for="redes">Redes Sociales</label>
                <input type="checkbox" id="amigo" name="amigo">
                <label for="amigo">Amigo</label>
            </div>
            <br><br>
            <div class="form-group">
                <input type="submit" value="Votar" id="botonVotar">
            </div>
        </form>
    </div>
    <script>
        // Cargar opciones de regiones en el select
        // Tu código para cargar opciones de regiones aquí

        // Manejar evento de cambio en el select de regiones
        $('#region').change(function () {
            var selectedRegion = $(this).val();

            console.log("region", selectedRegion);

            // Hacer una solicitud AJAX al servidor para obtener las comunas
            $.ajax({
                url: 'obtener_comunas.php', // Archivo PHP para obtener comunas
                type: 'POST',
                data: { regionId: selectedRegion },
                success: function (data) {
                    // Actualizar el select de comunas con las opciones obtenidas
                    $('#comuna').html(data);
                }
            });
        });

    </script>
</body>

</html>