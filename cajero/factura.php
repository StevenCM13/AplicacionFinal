<?php
// Conexión a la base de datos
include("../conexion.php");
$con = conectar();
// Verificar la conexión
if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

// Obtener la mesa seleccionada
$mesa = $_POST['mesas'];
// Obtener la sede del mesero
session_start();

$correo = $_SESSION['cajero'];
$sede_query = mysqli_query($con, "SELECT id_sede FROM usuarios WHERE correo = '$correo' AND rol = 'cajero'");
$sede = mysqli_fetch_assoc($sede_query)['id_sede'];

// Consulta para obtener las mesas disponibles de la sede del cajero
$sql = "SELECT * FROM mesas WHERE id_sede = $sede";
$result = $con->query($sql);

//Consulta para obtener los pedidos
$pedido_query = mysqli_query($con, "SELECT id_pedido, id_mesa FROM pedidos WHERE id_sede = '$sede'");
$pedido = mysqli_fetch_assoc($pedido_query);
$id_pedido = $pedido['id_pedido'];
$id_mesa = $pedido['id_mesa'];


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 0;
        }

        h2 {
            font-size: 18px;
            margin-bottom: 0;
        }

        table {
            border-collapse: collapse;
            margin-bottom: 20px;
            width: 100%;
        }

        table th,
        table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .total {
            font-weight: bold;
            margin-top: 20px;
            text-align: right;
        }

        .footer {
            font-size: 12px;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <h1>Factura</h1>
        <h2>Mesa: <?php echo $mesa; ?> </h2>
        <h2>Número de factura: 12345</h2>
    </header>
    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Precio unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Hamburguesa</td>
                <td>$10.00</td>
                <td>2</td>
                <td>$20.00</td>
            </tr>
            <tr>
                <td>Refresco</td>
                <td>$2.50</td>
                <td>3</td>
                <td>$7.50</td>
            </tr>
            <tr>
                <td>Café</td>
                <td>$3.00</td>
                <td>1</td>
                <td>$3.00</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td>Subtotal:</td>
                <td>$30.50</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Impuesto:</td>
                <td>$4.58</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Total:</td>
                <td>$35.08</td>
            </tr>
        </tfoot>
    </table>
    <div class="total">
        Total: $35.08
    </div>
    <div class="footer">
        Gracias por su visita
    </div>
</body>

</html>