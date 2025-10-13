(async () => {
  try {
    const base = 'http://127.0.0.1:8001';
    const loginRes = await fetch(base + '/api/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email: 'demo@example.com', password: 'contraseña_demo' })
    });
    const loginJson = await loginRes.json();
    console.log('LOGIN', loginRes.status, loginJson.token ? 'OK' : 'NO_TOKEN');
    const token = loginJson.token;

    const createRes = await fetch(base + '/api/viajes', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', Authorization: 'Bearer ' + token },
      body: JSON.stringify({ origen: 'Casa_e2e', destino: 'Oficina_e2e', vehiculo: 'Auto_e2e', fecha: '2025-09-27' })
    });
    const createText = await createRes.text();
    console.log('CREATE', createRes.status, createText);

    const listRes = await fetch(base + '/api/viajes', {
      headers: { Authorization: 'Bearer ' + token }
    });
    const listJson = await listRes.json();
    console.log('LIST', listRes.status, 'items=' + (Array.isArray(listJson) ? listJson.length : '??'));
    if (Array.isArray(listJson)) console.log(JSON.stringify(listJson.slice(0,5), null, 2));
  } catch (e) {
    console.error('ERROR', e);
    process.exit(1);
  }
})();
