<?php
// Conexión a la base de datos
include("../conexion.php");
$con = conectar();

// Verificar la conexión
if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

// Consulta para obtener las mesas disponibles
$sql = "SELECT * FROM mesas";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Seleccionar mesa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="estilo_mesas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body>
    <header>
        <h1>Selecciona una mesa:</h1>
    </header>

    <main>
        <table class="table">
            <thead>
                <tr>
                    <th>Número de mesa</th>
                    <th>Sede</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['numero_mesa']; ?></td>
                        <td><?php
                            $sede_id = $row['id_sede'];
                            $sede_query = mysqli_query($con, "SELECT nombre_sede FROM sedes WHERE id_sede = '$sede_id'");
                            $sede_nombre = mysqli_fetch_assoc($sede_query)['nombre_sede'];
                            echo $sede_nombre;
                            ?></td>
                        <td><a href="pedidos.php?mesa=<?php echo $row['id_mesa']; ?>">Seleccionar</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <footer>
            <a href="../Administrador/menu_admin.php" class="btn btn-primary">Menú principal</a>
            <br>
            <a href="../cerrar_sesion.php" class="btn btn-danger mt-3">Cerrar sesión</a>

        </footer>
    </main>
</body>

</html>