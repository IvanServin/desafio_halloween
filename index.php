<?php
session_start();

// Mostrar la alerta si existe
if (isset($_SESSION['voto_error'])) {
    echo '<script>alert("' . $_SESSION['voto_error'] . '");</script>';
    unset($_SESSION['voto_error']); // Limpiar la variable después de mostrar la alerta
}
?>
<?php
$con = mysqli_connect("localhost", "root", "", "halloween");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Concurso de disfraces de Halloween</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <nav>
        <ul>
            <li><a href="#disfraces-list">Ver Disfraces</a></li>
            <li><a href="#registro">Registro</a></li>
            <li><a href="#login">Iniciar Sesión</a></li>
            <?php
             if (isset(($_SESSION['id_usuario']))){
                echo '<li><a href="php/admin.php">Panel de Administración</a></li>';



            }
            ?>
            
        </ul>
    </nav>
    <header>
        <h1>Concurso de disfraces de Halloween</h1>
    </header>
    <main>
        <section id="disfraces-list" >
            <!-- Aquí se mostrarán los disfraces -->
            <?php
            // Conexión a la base de datos
            $con = mysqli_connect("localhost", "root", "", "halloween");

            if ($con) {
                // Consulta para obtener todos los disfraces junto con el conteo de votos
                $sql = "SELECT d.id, d.nombre, d.descripcion, d.foto, COUNT(v.id) AS total_votos
                FROM disfraces d
                LEFT JOIN votos v ON d.id = v.id_disfraz
                WHERE d.eliminado = 0
                GROUP BY d.id, d.nombre, d.descripcion, d.foto";
                $result = mysqli_query($con, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="section">'; // Contenedor para cada disfraz
                        echo '<div class="disfraz">';
                        echo '<h2>' . htmlspecialchars($row['nombre']) . '</h2>';
                        echo '<p>' . htmlspecialchars($row['descripcion']) . '</p>';
                        echo '<p><img src="imagenes/' . htmlspecialchars($row['foto']) . '" width="100%"></p>';
                        echo '<p>Total de votos: ' . (int) $row['total_votos'] . '</p>'; // Mostrar total de votos
                        echo '<form action="php/registrar_voto.php" method="POST" style="display:inline;">';
                        echo '<input type="hidden" name="disfraz_id" value="' . $row['id'] . '">';
                        echo '<button type="submit">Votar</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>'; // Cierra el contenedor del disfraz
                    }
                } else {
                    echo '<p>No hay disfraces disponibles.</p>';
                }
            }

            // Cerrar la conexión
            mysqli_close($con);
            ?>
        </section>


        <section id="registro" class="section">
            <h2>Registro</h2>
            <form action="php/procesar_registro.php" method="POST">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Registrarse</button>
            </form>
        </section>
        <section id="login" class="section">
            <h2>Iniciar Sesión</h2>
            <form action="php/procesar_login.php" method="POST">
                <label for="login-username">Nombre de Usuario:</label>
                <input type="text" id="login-username" name="login-username" required>

                <label for="login-password">Contraseña:</label>
                <input type="password" id="login-password" name="login-password" required>

                <button type="submit">Iniciar Sesión</button>
            </form>
        </section>
       
    </main>
    <script src="js/script.js"></script>
</body>

</html>
