const passwordInput = document.getElementById('ContraseñaRegistro');
const passwordStrength = document.querySelector('.password-strength');
const strengthIcons = passwordStrength.querySelectorAll('.icons i');

passwordInput.addEventListener('input', checkPasswordStrength);

function checkPasswordStrength() {
  const password = passwordInput.value.trim();
  let validCount = 0;

  // Ocultar los íconos de palomita y equis si el campo de contraseña está vacío
  if (password === '') {
    strengthIcons.forEach(icon => {
      icon.classList.remove('checked');
      icon.classList.remove('hidden');
    });
    passwordStrength.classList.remove('valid');
    return;
  }

  // Verificar la longitud mínima de 8 caracteres
  if (password.length >= 8) {
    strengthIcons[0].classList.add('checked');
    validCount++;
  } else {
    strengthIcons[0].classList.remove('checked');
  }

  // Verificar si contiene al menos una letra mayúscula
  if (/[A-Z]/.test(password)) {
    strengthIcons[1].classList.add('checked');
    validCount++;
  } else {
    strengthIcons[1].classList.remove('checked');
  }

  // Verificar si contiene al menos un carácter que no sea texto
  if (/[^\w\s]/.test(password)) {
    strengthIcons[2].classList.add('checked');
    validCount++;
  } else {
    strengthIcons[2].classList.remove('checked');
  }

  // Agrega la clase 'checked' o 'hidden' según se cumplan las condiciones
  strengthIcons.forEach((icon, index) => {
    if (index < validCount) {
      icon.classList.add('checked');
      icon.classList.remove('hidden');
    } else {
      icon.classList.remove('checked');
      icon.classList.add('hidden');
    }
  });

  // Mostrar solo la palomita si todos los requisitos se cumplen
  if (validCount === 3) {
    passwordStrength.classList.add('valid');
  } else {
    passwordStrength.classList.remove('valid');
  }
}





