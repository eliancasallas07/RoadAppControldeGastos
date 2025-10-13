// public/test-login.js
// Prueba POST de login con backend Symfony
(function(){
  const url = 'http://127.0.0.1:8000/login'; // endpoint que genera JWT
  const payload = {
    email: 'demo@example.com',   // Cambia por tu usuario real
    password: 'contraseña_demo' // Cambia por tu contraseña real
  };

  fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
  // no usamos cookies aquí, usamos JWT en respuesta
    body: JSON.stringify(payload)
  })
  .then(async response => {
    const text = await response.text();
    try {
      const data = JSON.parse(text);
      console.log('Respuesta JSON del login:', data);
    } catch (e) {
      console.log('Respuesta (no JSON) del login:', text);
    }
  })
  .catch(error => {
    console.error('Error de conexión o CORS en login:', error);
  });
})();

