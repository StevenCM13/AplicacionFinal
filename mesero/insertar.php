<?php
/*include("../conexion.php");


$con = conectar();

// Obtener la sede del mesero
session_start();

$correo = $_SESSION['mesero'];
$sede_query = mysqli_query($con, "SELECT id_sede FROM usuarios WHERE correo = '$correo' AND rol = 'mesero'");
$sede = mysqli_fetch_assoc($sede_query)['id_sede'];
$id_usuario_query = mysqli_query($con, "SELECT id_usuario FROM usuarios WHERE correo = '$correo' AND rol = 'mesero'");
$id_usuario = mysqli_fetch_assoc($id_usuario_query)['id_usuario'];

$id_articulo = $_POST["articulo"];
$mesa = $_POST['mesa'];
$cantidad = $_POST["cantidad"];



$sql = "INSERT INTO `pedidos`(`id_articulo`, id_mesa ,`cantidad`, `id_usuario`, `id_sede`, `fecha`) 
        VALUES ('$id_articulo',$mesa,'$cantidad',$id_usuario,'$sede',NOW())";

if (mysqli_query($con, $sql)) {
    echo "Pedido registrado correctamente";
    header("Location: mesero.php");
} else {
    echo "Error al registrar pedido: " . $sql . "<br>" . mysqli_error($con);
}

*/

include("../conexion.php");

$con = conectar();

// Obtener la sede del mesero
session_start();
$correo = $_SESSION['mesero'];
$sede_query = mysqli_query($con, "SELECT id_sede FROM usuarios WHERE correo = '$correo' AND rol = 'mesero'");
$sede = mysqli_fetch_assoc($sede_query)['id_sede'];
$id_usuario_query = mysqli_query($con, "SELECT id_usuario FROM usuarios WHERE correo = '$correo' AND rol = 'mesero'");
$id_usuario = mysqli_fetch_assoc($id_usuario_query)['id_usuario'];
// Obtener las demas variables
$id_articulo = $_POST["articulo"];
$mesa = $_POST['mesa'];
$cantidad = $_POST["cantidad"];

// Obtener la cantidad actual del artículo en el inventario
$cantidad_actual_query = mysqli_query($con, "SELECT cantidad FROM inventario WHERE id_articulo = $id_articulo");
$cantidad_actual = mysqli_fetch_assoc($cantidad_actual_query)['cantidad'];

if ($cantidad_actual < $cantidad) {
    echo '
    <script>
        alert ("No hay suficientes unidades en el inventario."); 
        window.location = "mesero.php";  
    </script>
    ';
    exit();
} else {
    // Actualizar la cantidad en el inventario
    $nueva_cantidad = $cantidad_actual - $cantidad;
    mysqli_query($con, "UPDATE inventario SET cantidad = $nueva_cantidad WHERE id_articulo = $id_articulo");
    echo '
    <script> 
        alert ("Pedido registrado correctamente");
        window.location = "mesero.php";  
    </script>
    ';

    // Verificar si ya existe un registro del artículo para la mesa y el mesero
    $registro_query = mysqli_query($con, "SELECT * FROM pedidos WHERE id_articulo = $id_articulo AND id_mesa = $mesa AND id_usuario = $id_usuario");
    if (mysqli_num_rows($registro_query) > 0) {

        // Si ya existe un registro, actualizar la cantidad
        $registro = mysqli_fetch_assoc($registro_query);
        $nueva_cantidad = $registro['cantidad'] + $cantidad;
        $pedido_id = $registro['id_pedido'];
        mysqli_query($con, "UPDATE pedidos SET cantidad = $nueva_cantidad WHERE id_pedido = $pedido_id");
        echo '
        <script>
            alert ("Error al registrar pedido: " . $sql . "<br>" . mysqli_error($con)");
        </script>
        ';
    } else {
        // Si no existe un registro, insertar un nuevo registro
        $sql = "INSERT INTO `pedidos`(`id_articulo`, id_mesa ,`cantidad`, `id_usuario`, `id_sede`, `fecha`) 
                VALUES ('$id_articulo',$mesa,'$cantidad',$id_usuario,'$sede',NOW())";

        if (mysqli_query($con, $sql)) {
            echo '
            <script>
                alert ("Pedido registrado correctamente");
            </script>
            ';
        } else {
            echo '
            <script>
                alert ("Error al registrar pedido: " . $sql . "<br>" . mysqli_error($con));
            </script>
            ';
        }
    }
    echo '<script>window.location = "mesero.php";</script>';
}

mysqli_close($con);
exit();
