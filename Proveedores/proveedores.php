<?php
include("../conexion.php");
$con = conectar();

$sql = "SELECT * FROM proveedores WHERE id_proveedor > 0";
$query = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Crear Proveedores Bar</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <h1>Ingrese los datos del proveedor </h1>
                <form action="insertar.php" method="POST">
                    <input type="number" class="form-control mb-3" name="nit" placeholder="NIT" required>
                    <input type="text" class="form-control mb-3" name="nombre_proveedor" placeholder="Nombre del proveedor" required>
                    <input type="text" class="form-control mb-3" name="ciudad" placeholder="Ciudad" required>

                    <br>
                    <br>
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
                <br>
                <a href="../Administrador/menu_admin.php" class="btn btn-danger">Menú principal</a>
            </div>
            <div class="col-md-8">
                <table class="table">
                    <thead class="table-success table-striped">
                        <tr>
                            <th>NIT</th>
                            <th>Nombre del proveedor</th>
                            <th>Ciudad</th>
                            <th>Sede</th>
                            <th>Fecha de creación</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $row['nit'] ?></td>
                                <td><?php echo $row['nombre_proveedor'] ?></td>
                                <td><?php echo $row['ciudad'] ?></td>
                                <td>
                                    <?php
                                    // Código PHP para conectarse a la base de datos y obtener el nombre de la sede del proveedor
                                    $con2 = mysqli_connect("localhost", "root", "", "bar");
                                    $sql2 = "SELECT nombre_sede FROM sedes WHERE id_sede = '{$row['id_sede']}'";
                                    $query2 = mysqli_query($con2, $sql2);
                                    $result2 = mysqli_fetch_assoc($query2);

                                    echo $result2['nombre_sede'];

                                    // Cerrar la conexión a la base de datos
                                    mysqli_close($con2);
                                    ?>
                                </td>
                                <td><?php echo $row['fecha'] ?></td>
                                <td><a href="delete.php?id_proveedor=<?php echo $row['id_proveedor'] ?>" class="btn btn-danger">Eliminar</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>