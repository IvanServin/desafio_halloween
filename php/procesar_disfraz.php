<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $con = mysqli_connect("localhost", "root", "", "halloween");

    if (!$con) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Obtener y escapar datos del formulario
    $disfrazNombre = mysqli_real_escape_string($con, $_POST['disfraz-nombre']);
    $disfrazDescripcion = mysqli_real_escape_string($con, $_POST['disfraz-descripcion']);

    // Manejo de la subida de archivos
    if (isset($_FILES['disfraz-foto']) && $_FILES['disfraz-foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['disfraz-foto'];
        $nombreFoto = basename($foto['name']);
        $rutaDestino = '../imagenes/' . $nombreFoto;

        // Validaciones
        $tiposPermitidos = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $tipoArchivo = mime_content_type($foto['tmp_name']);
        
        // Validar tipo de archivo
        if (!in_array($tipoArchivo, $tiposPermitidos)) {
            echo "Formato de archivo no válido.";
            exit();
        }

        // Validar tamaño de archivo
        if ($foto['size'] > 2000000) { // Limite de 2MB
            echo "El archivo es demasiado grande.";
            exit();
        }

        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
            // Insertar datos en la base de datos
            $sql = "INSERT INTO disfraces (nombre, descripcion, foto) VALUES ('$disfrazNombre', '$disfrazDescripcion', '$rutaDestino')";
            
            if (mysqli_query($con, $sql)) {
                header("Location: ../index.php#disfraces-list");
                exit();
            } else {
                echo "Error al agregar el disfraz: " . mysqli_error($con);
            }
        } else {
            echo "Error al subir la foto.";
        }
    } else {
        echo "No se ha seleccionado ninguna foto o ha ocurrido un error.";
    }

    // Cerrar la conexión
    mysqli_close($con);
} else {
    echo "Error: Método de solicitud no válido.";
}
?>
