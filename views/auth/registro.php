<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro – Glamour Stock</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Segoe UI',sans-serif;background:linear-gradient(135deg,#c0637e 0%,#3d2b3d 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.box{background:white;border-radius:20px;padding:50px 44px;max-width:480px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.3)}
@media(max-width:520px){body{padding:0;align-items:flex-start}.box{border-radius:0;min-height:100vh;padding:36px 20px}}
.logo{font-size:2.2em;margin-bottom:4px}
h2{font-size:1.6em;color:#3d2b3d;margin-bottom:4px}
p.sub{color:#888;font-size:.88em;margin-bottom:24px}
.fg{margin-bottom:14px}
.fg label{display:block;font-size:.8em;font-weight:600;color:#555;margin-bottom:4px}
.fg input{width:100%;padding:11px 14px;border:2px solid #e0d0d8;border-radius:8px;font-size:.9em;outline:none;transition:border-color .2s}
.fg input:focus{border-color:#c0637e}
.btn{width:100%;padding:13px;background:linear-gradient(135deg,#c0637e,#a5506a);color:white;border:none;border-radius:8px;font-size:.95em;font-weight:700;cursor:pointer;margin-top:6px}
.btn:hover{opacity:.9}
.links{text-align:center;margin-top:16px;font-size:.82em;color:#888}
.links a{color:#c0637e;text-decoration:none;font-weight:600}
.alert-err{background:#f8d7da;color:#842029;padding:10px 14px;border-radius:7px;font-size:.85em;font-weight:600;margin-bottom:14px}
.alert-ok{background:#d1e7dd;color:#0f5132;padding:10px 14px;border-radius:7px;font-size:.85em;font-weight:600;margin-bottom:14px}
</style>
</head>
<body>
<div class="box">
  <div class="logo"></div>
  <h2>Crear cuenta</h2>
  <p class="sub">Regístrate como cliente de Glamour Stock</p>

  <?php if (!empty($error)): ?>
  <div class="alert-err"><?= $error ?></div>
  <?php endif; ?>
  <?php if (!empty($success)): ?>
  <div class="alert-ok"><?= $success ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="fg">
      <label>Nombre completo</label>
      <input type="text" name="nombre" placeholder="Tu nombre" required>
    </div>
    <div class="fg">
      <label>Correo electrónico</label>
      <input type="email" name="correo" placeholder="correo@ejemplo.com" required>
    </div>
    <div class="fg">
      <label>Teléfono</label>
      <input type="tel" name="telefono" placeholder="3XX XXX XXXX">
    </div>
    <div class="fg">
      <label>Contraseña</label>
      <input type="password" name="password" placeholder="Mínimo 8 caracteres" required>
    </div>
    <button type="submit" class="btn">Crear cuenta</button>
  </form>

  <div class="links">
    ¿Ya tienes cuenta? <a href="index.php?controller=auth&action=login">Iniciar sesión</a>
  </div>
</div>
</body>
</html>
