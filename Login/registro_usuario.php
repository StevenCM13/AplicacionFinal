<?php

include('conexion.php');

/*Variables*/
$tipo_documento = TRIM($_POST['tipo_documento']);
$numero_documento = TRIM($_POST['numero_documento']);
$correo = TRIM($_POST['correo']);
$contraseña = $_POST['contraseña'];
$confirmar_contraseña = $_POST['confirmar_contraseña'];
//Para encriptar la contraseña
//$contraseña = hash('sha512', $contraseña);

// Validar el tipo de documento ingresado
switch ($tipo_documento) {
    case 'CC':
        // Cédula de ciudadanía
        $tipo_documento_valido = true;
        break;
    case 'TI':
        // Tarjeta de identidad
        $tipo_documento_valido = true;
        break;
    case 'CE':
        // Cédula de extranjería
        $tipo_documento_valido = true;
        break;
    default:
        // Tipo de documento no válido
        $tipo_documento_valido = false;

        echo '
        <script>
            alert("Tipo de documento no válido. Por favor, seleccione una opción válida en Mayúscula.");
            window.location = "../index.php";
        </script>
    ';
        exit();
}

// Validar que las contraseñas ingresadas coincidan
if ($contraseña != $confirmar_contraseña) {
    echo '
    <script>
        alert("Las contraseñas no coinciden. Por favor, inténtalo de nuevo.");
        window.location = "../index.php";
    </script>
';
    $query = "";
} elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {

    echo '
    <script>
        alert("El correo electrónico ingresado no es válido. Por favor, inténtalo de nuevo.");
        window.location = "../index.php";
    </script>
';
    $query = "";
} else {
    // Encriptar la contraseña antes de guardarla en la base de datos
    $contraseña = hash('sha512', $contraseña);

    /*Variable query*/
    $query = "INSERT INTO registro_alumnos (tipo_documento, numero_documento, correo_electronico, contraseña, fecha_registro) 
         VALUES ('$tipo_documento','$numero_documento','$correo','$contraseña', NOW())";

    echo "Usuario registrado exitosamente!";
}

/*Verificar que el numero de documento no se repita en la BD*/
$verificar_documento = mysqli_query($conexion, "SELECT *FROM registro_alumnos WHERE tipo_documento = '$tipo_documento' AND numero_documento = '$numero_documento'");

if (mysqli_num_rows($verificar_documento) > 0) {
    echo '
        <script>
            alert("Este numero de documento ya está registrado, intenta con otro diferente");
            window.location = "../index.php";
        </script>
    ';
    //Para que no se ejecute el codigo de abajo
    exit();
}

/*Verificar que el correo no se repita en la BD*/
$verificar_correo = mysqli_query($conexion, "SELECT *FROM registro_alumnos WHERE correo_electronico = '$correo'");

if (mysqli_num_rows($verificar_correo) > 0) {
    echo '
        <script>
            alert("Este correo ya está registrado, intenta con otro diferente");
            window.location = "../index.php";
        </script>
    ';
    //Para que no se ejecute el codigo de abajo
    exit();
}

/*ejecicion del query*/
$ejecutar = mysqli_query($conexion, $query);

/*Si ingresa los datos correctamente*/
if ($ejecutar) {
    echo '
    <script>
        alert ("¡Te has registrado correctamente!");
        window.location = "../index.php";
    </script>
    ';
} else {
    echo '
    <script>
        alert ("Algo salió mal, por favor inténtalo nuevamente");
        window.location = "../index.php";
    </script>
    ';
}

/*Para cerrar la conexión*/
mysqli_close($conexion);
