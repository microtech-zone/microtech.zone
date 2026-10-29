# Microtech · Repuestos electrónicos y Reparaciones

Sitio web oficial de Microtech para la venta de recambios electrónicos (móviles, consolas, portátiles y accesorios) y gestión de solicitudes de reparaciones con pedidos directos a través de WhatsApp (**+34 624 945 545**).

---

## 🚀 Despliegue en Vercel (Recomendado)

El proyecto cuenta con `index.html` y `vercel.json` optimizados para despliegue instantáneo en la red global de Vercel (Edge CDN):

1. Conecta tu repositorio de GitHub `https://github.com/microtech-zone/microtech.zone` en tu cuenta de [Vercel](https://vercel.com).
2. Selecciona **Import Project**.
3. Deja la configuración predeterminada (Framework: *Other*) y haz clic en **Deploy**.
4. ¡Listo! Tu web estará publicada al instante con certificado SSL y dominio `.vercel.app` o tu dominio personalizado `microtech.zone`.

---

## 💻 Ejecución en local (Desarrollo)

Haz doble clic en `iniciar_servidor.bat` o ejecuta:

```powershell
php -S localhost:8000 router.php
```

Visita `http://localhost:8000` en tu navegador.

---

## 🌐 Publicación alternativa en Hostinger / cPanel (PHP + MySQL)

1. En hPanel / cPanel crea una base de datos MySQL y un usuario con permisos.
2. Abre phpMyAdmin e importa `database.sql`.
3. Edita `config.php` con los datos de conexión creados.
4. Sube el contenido a `public_html`.
5. Accede a `https://tu-dominio/admin/login.php` para gestionar productos desde el panel PHP.
