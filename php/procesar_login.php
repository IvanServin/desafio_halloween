<?php
session_start(); // Asegúrate de que la sesión esté iniciada

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $con = mysqli_connect("localhost", "root", "", "halloween");

    if ($con) {
        // Datos del formulario 
        $username = mysqli_real_escape_string($con, $_POST['login-username']);
        $password = mysqli_real_escape_string($con, $_POST['login-password']);

        // Consulta para obtener el usuario
        $sql = "SELECT * FROM usuarios WHERE nombre='$username'";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Verificar la contraseña
            if ($row['clave'] === $password) {
                echo "Inicio de sesión exitoso. Bienvenido, " . htmlspecialchars($username) . "!";
                
                // Almacenar el ID del usuario en la sesión
                $_SESSION['id_usuario'] = $row['id']; // Almacena el ID del usuario

                // Redirigir a la página principal
                header("Location: ../index.php");
                exit();
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Usuario no encontrado.";
        }

        // Cerrar la conexión
        mysqli_close($con);
    } else {
        echo "No se pudo conectar a la base de datos: " . mysqli_connect_error();
    }
} else {
    echo "Error.";
}
?>
