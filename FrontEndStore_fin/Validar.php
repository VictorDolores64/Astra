<?php
// Realizar la conexión a la base de datos
$server = "localhost";
$usuario = "root";
$pass = "";
$bd = "astra";
$conexion = new mysqli($server, $usuario, $pass, $bd);

if ($conexion->connect_errno) {
    die("Error de conexión: " . $conexion->connect_errno);
}

// Verificar si se enviaron los datos de inicio de sesión
if (isset($_POST['Correo']) && isset($_POST['Contraseña'])) {
    // Obtener los datos enviados desde el cliente
    $correo = $_POST['Correo'];
    $contraseña = md5($_POST['Contraseña']); // Convertir la contraseña ingresada a MD5 (considera usar algoritmos de cifrado más seguros)

    // Realizar la consulta en la base de datos utilizando una sentencia preparada
    $query = "SELECT * FROM usuarios WHERE Correo = ? AND Contraseña = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ss", $correo, $contraseña);
    $stmt->execute();

    // Obtener el resultado de la consulta
    $result = $stmt->get_result();
    $cantidad = $result->num_rows;

    // Preparar la respuesta JSON
    $respuesta = array(
        "autenticado" => false,
        "url" => "",
        "mensaje" => ""
    );

    if ($cantidad > 0) {
        // El usuario se autenticó correctamente
        $respuesta["autenticado"] = true;
        $respuesta["url"] = "index.html";

        // Iniciar la sesión y guardar información relevante en variables de sesión
        session_start();
        $_SESSION['autenticado'] = true;
        $_SESSION['usuario'] = $correo;
    } else {
        // El usuario no se autenticó correctamente
        $respuesta["mensaje"] = "El nombre de usuario o la contraseña son incorrectos. Intente de nuevo";
    }

    // Enviar la respuesta JSON al cliente
    header("Content-Type: application/json");
    echo json_encode($respuesta);
} else {
    // No se enviaron los datos de inicio de sesión
    // Manejar el caso en consecuencia, por ejemplo, mostrar un mensaje de error o redirigir al usuario a otra página
}
?>
