# Guía rápida de estilos

Este archivo muestra cómo ajustar rápidamente el look & feel del login y componentes relacionados mediante variables CSS.

Dónde están las variables
- `frontend/app/styles/app.css` contiene el bloque `:root { ... }` con las variables de tema.

Variables más útiles
- `--bg-gradient-start` / `--bg-gradient-end`: colores de fondo del login.
- `--brand-primary`: color del botón principal.
- `--brand-primary-dark`: color del botón al pasar el cursor.
- `--card-padding`, `--card-radius`: controlan el padding y el radio de las tarjetas.
- `--container-width`: ancho del bloque de login.

Ejemplos
- Cambiar a tema oscuro:
  ```css
  :root {
    --bg-gradient-start: #0f172a;
    --bg-gradient-end: #0b1221;
    --card-bg: #0b1221;
    --text-color: #e5e7eb;
    --brand-primary: #7c3aed;
    --brand-primary-dark: #6d28d9;
  }
  ```

- Hacer inputs más grandes:
  ```css
  :root {
    --input-padding: 12px;
    --container-width: 420px;
  }
  ```

Cómo probar en caliente
- Con el servidor de desarrollo `npm start`, guarda los cambios en `app.css` y recarga la página. Ember recompilará y aplicará los cambios.

Notas
- Si el build se cancela en Windows (ej. "Build Canceled"), puede ser por permisos de symlink o por archivos en OneDrive. Ejecuta PowerShell como Administrador o mueve el proyecto fuera de OneDrive.
