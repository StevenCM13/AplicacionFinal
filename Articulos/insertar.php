<?php
include("../conexion.php");

$con = conectar();

$nombre_articulo = $_POST["nombre_articulo"];
$cantidad = $_POST["cantidad"];
$precio = $_POST["precio"];
$proveedor = $_POST["proveedor"];
$sede = $_POST["sede"];

// Verificar si ya existe un registro con los mismos valores
$sql = "SELECT * FROM inventario WHERE nombre_articulo = '$nombre_articulo' AND id_proveedor = '$proveedor' AND id_sede = '$sede'";
$query = mysqli_query($con, $sql);

if (mysqli_num_rows($query) > 0) {
    // Si el registro ya existe, actualizar la cantidad
    $row = mysqli_fetch_assoc($query);
    $id_articulo = $row['id_articulo'];
    $nueva_cantidad = $row['cantidad'] + $cantidad;
    $sql = "UPDATE inventario SET cantidad = '$nueva_cantidad' WHERE id_articulo = '$id_articulo'";
} else {
    // Si el registro no existe, insertar un nuevo registro
    $sql = "INSERT INTO inventario (nombre_articulo, cantidad, precio, id_proveedor, id_sede, fecha) 
            VALUES ('$nombre_articulo', '$cantidad', '$precio', '$proveedor', '$sede', NOW())";
}

// Ejecutar la consulta SQL
if (mysqli_query($con, $sql)) {
    header("Location: articulos.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

mysqli_close($con);
