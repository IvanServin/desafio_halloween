<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $con = mysqli_connect("localhost", "root", "", "halloween");

    if ($con) {
        // Obtener y sanitizar los datos del formulario
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        // Consulta de inserción
        $sql = "INSERT INTO usuarios (nombre, clave) VALUES ('$username', '$password')";

        // Ejecutar la inserción
        if (mysqli_query($con, $sql)) {
            echo "Usuario registrado exitosamente.";
            header("location: ../index.php");
            exit();
        } else {
            echo "Error al registrar el usuario: " . mysqli_error($con);
        }

        // Cerrar la conexión
        mysqli_close($con);
    } else {
        echo "No se pudo conectar a la base de datos: " . mysqli_connect_error();
    }
} 
?>
