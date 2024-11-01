<?php
session_start(); // Asegúrate de que la sesión esté iniciada

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = mysqli_connect("localhost", "root", "", "halloween");
    if (!isset(($_SESSION['id_usuario']))){
        echo "<script>alert('Debes iniciar sesión para votar.'); window.location.href='../index.php';</script>";
        exit();
    }


    if ($con) {
        $disfrazId = intval($_POST['disfraz_id']);
        $usuarioId = $_SESSION['id_usuario']; // Asumiendo que el ID del usuario está en la sesión

        // Verificar si el usuario ya ha votado
        $checkSql = "SELECT * FROM votos WHERE id_usuario = $usuarioId AND id_disfraz = $disfrazId";
        $result = mysqli_query($con, $checkSql);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['voto_error'] = "¡No puedes votar más de una vez!";
            header("Location: ../index.php");
            exit();
        } else {
            // Insertar el nuevo voto
            $sql = "INSERT INTO votos (id_usuario, id_disfraz) VALUES ($usuarioId, $disfrazId)";
            if (mysqli_query($con, $sql)) {
                // Opcional: Actualizar el contador de votos en la tabla disfraces
                $updateSql = "UPDATE disfraces SET votos = votos + 1 WHERE id = $disfrazId";
                mysqli_query($con, $updateSql);

                header("Location: ../index.php#disfraces-list");
                exit();
            } else {
                echo "Error al registrar el voto: " . mysqli_error($con);
            }
        }

        mysqli_close($con);
    } else {
        echo "No se pudo conectar a la base de datos: " . mysqli_connect_error();
    }
} else {
    echo "Método de solicitud no válido.";
}
header("locate: ../index.php");
exit();
?>