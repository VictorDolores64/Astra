<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "astra";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

// Obtener los datos de la solicitud AJAX
$data = json_decode(file_get_contents('php://input'), true);

// Obtener los valores de los campos del formulario
$nombre = $data['nombre'];
$apellidoMaterno = $data['apellidoPaterno'];
$apellidoPaterno = $data['apellidoMaterno'];
$correo = $data['correo'];
$contraseña = $data['contraseña'];

// Verificar si el correo ya está registrado
$checkEmailQuery = "SELECT COUNT(*) as count FROM usuarios WHERE Correo = '$correo'";
$checkEmailResult = $conn->query($checkEmailQuery);
$checkEmailData = $checkEmailResult->fetch_assoc();

if ($checkEmailData['count'] > 0) {
    // El correo ya está registrado, enviar respuesta de error
    $response['message'] = "Error en el registro: El correo ya está registrado";
    echo json_encode($response);
    exit; // Terminar la ejecución del script
}

// Insertar los datos en la base de datos
$sql = "INSERT INTO usuarios (Nombre, ApellidoPaterno, ApellidoMaterno, Correo, Contraseña)
        VALUES ('$nombre', '$apellidoMaterno', '$apellidoPaterno', '$correo', '$contraseña')";

$response = array(); // Crear un arreglo para la respuesta

if ($conn->query($sql) === TRUE) {
    $response['message'] = "Registro exitoso";

    // Generar la URL encriptada
    $encryptedUrl = encryptUrl($nombre, $apellidoMaterno, $apellidoPaterno, $correo);

    // Agregar la URL encriptada a la respuesta
    $response['encryptedUrl'] = $encryptedUrl;
} else {
    $response['message'] = "Error en el registro: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();

// Enviar la respuesta al cliente
header('Content-Type: application/json');
echo json_encode($response);

// Función para encriptar la URL
function encryptUrl($nombre, $apellidoMaterno, $apellidoPaterno, $correo) {
    $data = "$nombre|$apellidoMaterno|$apellidoPaterno|$correo";
    $encryptedData = base64_encode($data);

    // Retornar la URL encriptada
    return $encryptedData;
}
?>
