<link rel="stylesheet" href="../css/estilos.css">
<nav>
    <ul>
        <li><a href="../index.php#disfraces-list">Ver Disfraces</a></li>
        <li><a href="../index.php#registro">Registro</a></li>
        <li><a href="../index.php#login">Iniciar Sesión</a></li>
        <?php
        if (isset(($_SESSION['id_usuario']))) {
            echo '<li><a href="php/admin.php">Panel de Administración</a></li>';



        }
        ?>

    </ul>
</nav>
<section id="admin" class="section">
    <h2>Panel de Administración</h2>
    <form action="php/procesar_disfraz.php" method="POST" enctype="multipart/form-data">
        <label for="disfraz-nombre">Nombre del Disfraz:</label>
        <input type="text" id="disfraz-nombre" name="disfraz-nombre" required>

        <label for="disfraz-descripcion">Descripción del Disfraz:</label>
        <textarea id="disfraz-descripcion" name="disfraz-descripcion" required></textarea>

        <label for="disfraz-nombre">Foto:</label>
        <input type="file" id="disfraz-foto" name="disfraz-foto" required>

        <button type="submit">Agregar Disfraz</button>
    </form>
</section>