<?php
// Conexión a la base de datos
include("../conexion.php");
$con = conectar();
// Verificar la conexión
if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

// Obtener la sede del cajero
session_start();

$correo = $_SESSION['cajero'];
$sede_query = mysqli_query($con, "SELECT id_sede FROM usuarios WHERE correo = '$correo' AND rol = 'cajero'");
$sede = mysqli_fetch_assoc($sede_query)['id_sede'];

// Consulta para obtener las mesas disponibles de la sede del cajero
$sql = "SELECT * FROM mesas WHERE id_sede = $sede";
$result = $con->query($sql);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Generar factura</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body>
    <h1>Generar factura</h1>
    <form action="factura.php" method="POST">
        <div class="form-group">
            <label for="mesas">Seleccione la mesa:</label>
            <select class="form-control" id="mesas" name="mesas">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <option value="<?php echo $row['id_mesa']; ?>">Mesa <?php echo $row['numero_mesa']; ?></option>
                <?php } ?>
            </select>
            <!-- Agregar un campo oculto para pasar el valor seleccionado de la mesa -->
            <input type="hidden" name="mesa_seleccionada" value="<?php echo $row['id_mesa']; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Generar factura</button>
    </form>
    <a href="../cerrar_sesion.php">Cerrar sesión</a>
</body>

</html>