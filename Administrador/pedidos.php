<?php
include("../conexion.php");
$con = conectar();

$sql = "SELECT * FROM pedidos WHERE id_pedido > 0";
$query = mysqli_query($con, $sql);

// Consulta SQL para obtener los pedidos de la mesa seleccionada
$sql = "SELECT * FROM pedidos WHERE id_mesa = '{$_GET['mesa']}'";
$query = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pedidos</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <h1>Pedidos Mesa</h1>

                <form action="insertar.php" method="POST">
                    <label for="articulo"> </label>
                    <select id="articulo" name="articulo" required>
                        <option value="">-- Selecciona un producto --</option>
                        <?php
                        $result = mysqli_query($con, "SELECT * FROM inventario");

                        // Iterar a través de los resultados y mostrar cada sede como una opción
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row["id_articulo"] . "'>" . $row["nombre_articulo"] . "</option>";
                        }

                        ?>
                    </select>
                    <br>
                    <br>

                    <!-- Agrega un campo oculto con el valor de 'mesa' -->
                    <input type="hidden" name="mesa" value="<?php echo $_GET['mesa']; ?>">
                    <input type="number" class="form-control mb-3" name="cantidad" placeholder="Cantidad" required>

                    <input type="submit" value="Crear" class="btn btn-primary">
                </form>
                <br>
                <a href="mesero.php" class="btn btn-danger">Menú mesas</a>

            </div>
            <div class="col-md-8">
                <table class="table">
                    <thead class="table-success table-striped">
                        <tr>
                            <th>Nombre producto</th>
                            <th>Numero mesa</th>
                            <th>Cantidad</th>
                            <th>Nombre mesero</th>
                            <th>Sede</th>
                            <th>Fecha y hora</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td>
                                    <?php
                                    // Código PHP para conectarse a la base de datos y obtener el nombre de la sede del usuario

                                    $sql1 = "SELECT nombre_articulo FROM inventario WHERE id_articulo = '{$row['id_articulo']}'";
                                    $query1 = mysqli_query($con, $sql1);
                                    $result1 = mysqli_fetch_assoc($query1);

                                    echo $result1['nombre_articulo'];

                                    ?>
                                </td>
                                <td>
                                    <?php
                                    // Código PHP para conectarse a la base de datos y obtener el numero de la mesa
                                    $sql2 = "SELECT numero_mesa FROM mesas WHERE id_mesa = '{$row['id_mesa']}'";
                                    $query2 = mysqli_query($con, $sql2);
                                    $result2 = mysqli_fetch_array($query2);

                                    echo $result2['numero_mesa'];

                                    ?>
                                </td>
                                <td><?php echo $row['cantidad'] ?></td>
                                <td>
                                    <?php
                                    // Código PHP para conectarse a la base de datos y obtener el nombre del mesero

                                    $sql3 = "SELECT nombres FROM usuarios WHERE id_usuario = '{$row['id_usuario']}'";
                                    $query3 = mysqli_query($con, $sql3);
                                    $result3 = mysqli_fetch_assoc($query3);

                                    echo $result3['nombres'];

                                    ?>
                                </td>
                                <td>
                                    <?php
                                    // Código PHP para conectarse a la base de datos y obtener el nombre de la sede del mesero
                                    $sql4 = "SELECT nombre_sede FROM sedes WHERE id_sede = '{$row['id_sede']}'";
                                    $query4 = mysqli_query($con, $sql4);
                                    $result4 = mysqli_fetch_assoc($query4);

                                    echo $result4['nombre_sede'];

                                    // Cerrar la conexión a la base de datos
                                    //mysqli_close($con);
                                    ?>
                                </td>
                                <td><?php echo $row['fecha'] ?></td>
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