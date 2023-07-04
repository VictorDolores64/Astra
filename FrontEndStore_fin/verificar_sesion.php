<?php
session_start();

if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
    // El usuario está autenticado
    $response = array('loggedIn' => true);
} else {
    // El usuario no está autenticado
    $response = array('loggedIn' => false);
}

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
