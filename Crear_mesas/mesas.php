<?php
include("../conexion.php");
$con = conectar();

$sql = "SELECT * FROM mesas WHERE id_mesa > 0";
$query = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Crear mesas Bar</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="estilo_mesas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body>
    <div class="login-box">
        <img class="logo" src="imagenes/logo.png" alt="logo buzz bar" />
        <h1>CREACION DE MESAS</h1>

        <?php
        if (isset($_GET['error'])) {
            echo "<div class='alert alert-danger'>" . $_GET['error'] . "</div>";
        }
        ?>

        <form action="insertar.php" method="POST">
            <input type="number" class="form-control mb-3" name="numero_mesa" placeholder="Número de mesa" required>

            <label for="sede"> </label>
            <select id="sede" name="sede" required>
                <option value="">-- Selecciona una Sede --</option>
                <?php
                $result = mysqli_query($con, "SELECT * FROM sedes");

                // Iterar a través de los resultados y mostrar cada sede como una opción
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row["id_sede"] . "'>" . $row["nombre_sede"] . "</option>";
                }

                ?>
            </select>
            <br>
            <br>
            <input type="submit" value="Crear" class="btn btn-primary">
        </form>
        <a href="../Administrador/menu_admin.php" class="btn btn-danger">Menú principal</a>

    </div>
</body>
<html>