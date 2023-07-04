// Obtener una referencia al formulario y al botón de envío
const form = document.getElementById('login-form');
const submitBtn = document.getElementById('submit-btn');

// Agregar un evento al formulario para manejar el envío
form.addEventListener('submit', function(event) {
  event.preventDefault(); // Evitar el envío del formulario por defecto

  // Obtener los valores de los campos del formulario
  const nombre = document.getElementById('Nombre').value;
  const apellidoMaterno = document.getElementById('ApellidoPaterno').value;
  const apellidoPaterno = document.getElementById('ApellidoMaterno').value;
  const correo = document.getElementById('CorreoRegistro').value;
  const contraseña = document.getElementById('ContraseñaRegistro').value;

  // Validar la contraseña
  const password = contraseña.trim();
  const validCount = password.length >= 8 && /[A-Z]/.test(password) && /[^\w\s]/.test(password) ? 3 : 0;

  if (validCount !== 3) {
    // La contraseña no cumple los requisitos
    alert('La contraseña no cumple los requisitos. Debe contener al menos 8 caracteres, una mayúscula y un carácter especial.');
    return; // Detener la ejecución de la función si la contraseña no es válida
  }

  // Crear un objeto con los datos a enviar
  const data = {
    nombre: nombre,
    apellidoMaterno: apellidoPaterno,
    apellidoPaterno: apellidoMaterno,
    correo: correo,
    contraseña: contraseña
  };

  // Realizar la solicitud AJAX
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'registro.php', true); // Especificar la URL del archivo PHP
  xhr.setRequestHeader('Content-Type', 'application/json');

  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // La solicitud se completó con éxito
        const response = JSON.parse(xhr.responseText);
        console.log(response.message); // Mostrar el mensaje de respuesta del servidor

        if (response.message === 'Registro exitoso') {
          // Mostrar mensaje de registro exitoso
          alert('Registro exitoso');

          // Recargar la página
          window.location.reload();
        } else {
          // Mostrar mensaje de error
          alert(response.message);
        }
      } else {
        // Hubo un error en la solicitud
        console.error('Error en la solicitud:', xhr.status);
      }
    }
  };

  // Convertir el objeto de datos a JSON y enviarlo en la solicitud
  xhr.send(JSON.stringify(data));
});


