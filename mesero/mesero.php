<?php
// Conexión a la base de datos
include("../conexion.php");
$con = conectar();
// Verificar la conexión
if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

// Obtener la sede del mesero
session_start();

$correo = $_SESSION['mesero'];
$sede_query = mysqli_query($con, "SELECT id_sede FROM usuarios WHERE correo = '$correo' AND rol = 'mesero'");
$sede = mysqli_fetch_assoc($sede_query)['id_sede'];

// Consulta para obtener las mesas disponibles de la sede del cajero
$sql = "SELECT * FROM mesas WHERE id_sede = $sede";
$result = $con->query($sql);

?>


<!DOCTYPE html>
<html>

<head>
    <title>Seleccionar mesa</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body>
    <h1>Selecciona una mesa:</h1>
    <ul>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <li>
                <a href="../mesero/pedidos.php?mesa=<?php echo $row['id_mesa']; ?>">
                    Mesa <?php echo $row['numero_mesa']; ?>
                </a>
                (sede <?php
                        $sede_id = $row['id_sede'];
                        $sede_query = mysqli_query($con, "SELECT nombre_sede FROM sedes WHERE id_sede = '$sede_id'");
                        if ($sede_query) {
                            $sede_nombre = mysqli_fetch_assoc($sede_query)['nombre_sede'];
                            echo $sede_nombre;
                        } else {
                            echo "Sede no encontrada";
                        }
                        ?>)
            </li>
        <?php } ?>
        <li><a href="../cerrar_sesion.php">Cerrar sesión</a></li>
    </ul>
</body>

</html>