function cerrarSesion(event) {
    event.preventDefault();
    // Realizar una solicitud AJAX al archivo de cierre de sesión
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "logout.php", true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Verificar la respuesta del servidor
        var response = JSON.parse(xhr.responseText);
        if (response.cerrada) {
          // Redirigir al usuario al formulario de inicio de sesión
          window.location.href = "Login.html";
        }
      }
    };
    xhr.send();
  }
  
