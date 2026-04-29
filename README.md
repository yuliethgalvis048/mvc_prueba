# 💅 Glamour Stock – MVC_PRUEBA

Sistema de gestión de citas para salón de belleza, desarrollado con arquitectura MVC en PHP puro.

---

## 📁 Estructura del proyecto

```
MVC_PRUEBA/
├── index.php              ← Router principal (Front Controller)
├── glamour_stock.sql      ← Base de datos completa
├── .htaccess
├── config/
│   └── db.php             ← Conexión PDO a MySQL
├── includes/
│   └── Auth.php           ← Clase de autenticación y sesiones
├── controllers/
│   ├── AuthController.php
│   ├── AdminController.php
│   ├── ClienteController.php
│   ├── EmpleadoController.php
│   ├── CitaController.php
│   └── ServicioController.php
├── models/
│   ├── ClienteModel.php
│   ├── CitaModel.php
│   ├── ServicioModel.php
│   └── EmpleadoModel.php
├── views/
│   ├── _menu.php          ← Menú lateral compartido
│   ├── auth/
│   │   ├── login.php
│   │   └── registro.php
│   ├── admin/
│   │   ├── dashboard.php
│   │   ├── citas.php
│   │   ├── clientes.php
│   │   ├── empleados.php
│   │   └── servicios.php
│   ├── cliente/
│   │   ├── index.php      ← Mis citas
│   │   ├── catalogo.php
│   │   ├── agendar.php
│   │   └── perfil.php
│   └── empleado/
│       ├── index.php      ← Citas del día
│       └── perfil.php
└── public/
    └── css/
        └── main.css
```

---

## ⚙️ Instalación

### 1. Base de datos
- Abre phpMyAdmin o MySQL Workbench
- Importa el archivo `glamour_stock.sql`
- Se creará automáticamente la base de datos `g_s`

### 2. Servidor web
- Coloca la carpeta en `htdocs/` (XAMPP) o `www/` (WAMP)
- Asegúrate de que PHP >= 7.4 y extensión PDO estén activos

### 3. Acceder
```
http://localhost/MVC_PRUEBA/index.php
```

---

## 👤 Cuentas de prueba

| Rol       | Correo                      | Contraseña |
|-----------|-----------------------------|------------|
| Admin     | admin@glamourstock.com      | password   |
| Empleada  | empleada@glamourstock.com   | password   |
| Cliente   | cliente@glamourstock.com    | password   |

---

## 🧭 Rutas del sistema

| URL                                              | Descripción              |
|--------------------------------------------------|--------------------------|
| `index.php`                                      | Redirige según sesión    |
| `index.php?controller=auth&action=login`         | Login                    |
| `index.php?controller=auth&action=registro`      | Registro cliente         |
| `index.php?controller=admin&action=dashboard`    | Dashboard admin          |
| `index.php?controller=admin&action=citas`        | Gestión de citas         |
| `index.php?controller=admin&action=clientes`     | Gestión de clientes      |
| `index.php?controller=admin&action=empleados`    | Gestión de empleadas     |
| `index.php?controller=admin&action=servicios`    | Catálogo de servicios    |
| `index.php?controller=cliente&action=index`      | Mis citas (cliente)      |
| `index.php?controller=cliente&action=catalogo`   | Ver catálogo             |
| `index.php?controller=cliente&action=agendar`    | Agendar cita             |
| `index.php?controller=empleado&action=index`     | Citas del día (empleada) |

---

## 🔐 Roles y accesos

- **Admin**: Acceso completo (dashboard, citas, clientes, empleadas, servicios)
- **Empleado**: Dashboard, citas, clientes (lectura), perfil, citas del día
- **Cliente**: Mis citas, catálogo, agendar, perfil

---

## 🛠️ Tecnologías

- **Backend**: PHP 7.4+ MVC puro (sin frameworks)
- **Base de datos**: MySQL con PDO
- **Frontend**: HTML5 + CSS3 vanilla (sin librerías externas)
- **Autenticación**: Sesiones PHP + password_hash/verify

---**.
