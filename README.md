# Proyecto Inmobiliaria

## Descripción
Sistema web para gestión de propiedades inmobiliarias, con roles de administrador y agentes, gestión de usuarios, propiedades, imágenes y personalización de la página.

## Instalación
1. Clona el repositorio en tu servidor local (XAMPP recomendado).
2. Crea una base de datos MySQL llamada `proyecto` e importa la estructura correspondiente.
3. Configura los datos de conexión en `conexion_bd.php` si es necesario.
4. Asegúrate de que la carpeta `imagenes/` tenga permisos de escritura.
5. Accede a `index.php` desde tu navegador.

## Seguridad y buenas prácticas
- Las contraseñas se almacenan con `password_hash`.
- Se valida el tipo y tamaño de las imágenes subidas.
- Se recomienda usar HTTPS en producción.
- No compartas tus credenciales de base de datos.

## Mejoras sugeridas
- Implementar consultas preparadas (mysqli prepared statements) para máxima seguridad.
- Agregar protección CSRF en formularios.
- Mejorar validaciones de datos en formularios.

## Autor
Keizel-2005

