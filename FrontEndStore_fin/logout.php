<?php
// Iniciar la sesión
session_start();

// Verificar si hay una sesión activa
if (isset($_SESSION['usuario'])) {
  // Destruir la sesión
  session_destroy();
  $cerrada = true;
  // Eliminar la variable de sesión 'usuario'
  unset($_SESSION['usuario']);
} else {
  $cerrada = false;
}

// Preparar la respuesta JSON
$respuesta = array(
  "cerrada" => $cerrada
);

// Devolver la respuesta JSON
header("Content-Type: application/json");
echo json_encode($respuesta);
?>
