<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar Sesión – Glamour Stock</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Segoe UI',sans-serif;background:linear-gradient(135deg,#c0637e 0%,#3d2b3d 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.container{background:white;border-radius:20px;box-shadow:0 20px 60px rgba(0,0,0,.3);overflow:hidden;max-width:900px;width:100%;display:flex}
.left{flex:1;background:linear-gradient(135deg,#c0637e,#a5506a);color:white;padding:60px 40px;display:flex;flex-direction:column;justify-content:center}
.left h1{font-size:2.2em;margin-bottom:10px}
.left p{font-size:.95em;opacity:.9;line-height:1.6}
.features{margin-top:32px}
.feat{display:flex;align-items:center;gap:14px;margin-bottom:16px}
.feat-icon{width:44px;height:44px;background:rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.3em;flex-shrink:0}
.feat-text strong{display:block;font-size:.9em}
.feat-text span{font-size:.8em;opacity:.85}
.right{flex:1;padding:60px 40px;display:flex;flex-direction:column;justify-content:center}
.right h2{font-size:1.7em;color:#3d2b3d;margin-bottom:6px}
.right p{color:#888;font-size:.88em;margin-bottom:28px}
.form-group{margin-bottom:14px}
.form-group label{display:block;font-size:.8em;font-weight:600;color:#555;margin-bottom:4px}
.form-group input{width:100%;padding:11px 14px;border:2px solid #e0d0d8;border-radius:8px;font-size:.9em;outline:none;transition:border-color .2s}
.form-group input:focus{border-color:#c0637e}
.btn-login{width:100%;padding:13px;background:linear-gradient(135deg,#c0637e,#a5506a);color:white;border:none;border-radius:8px;font-size:.95em;font-weight:700;cursor:pointer;margin-top:6px;transition:opacity .2s}
.btn-login:hover{opacity:.9}
.links{text-align:center;margin-top:16px;font-size:.82em;color:#888}
.links a{color:#c0637e;text-decoration:none;font-weight:600}
.alert-err{background:#f8d7da;color:#842029;padding:10px 14px;border-radius:7px;font-size:.85em;font-weight:600;margin-bottom:14px}
.demo-box{background:#fdf5f8;border:1px solid #f0d8e2;border-radius:8px;padding:12px;margin-top:18px;font-size:.78em}
.demo-box strong{display:block;margin-bottom:6px;color:#3d2b3d}
.demo-row{display:flex;justify-content:space-between;padding:2px 0;color:#666}
@media(max-width:680px){
  .container{flex-direction:column;border-radius:0;min-height:100vh}
  .left{padding:28px 22px}
  .left h1{font-size:1.8em}
  .features{margin-top:18px}
  .feat{margin-bottom:12px}
  .right{padding:28px 22px}
  .right h2{font-size:1.4em}
}
@media(max-width:380px){
  body{padding:0}
  .right{padding:20px 14px}
  .btn-login{padding:12px}
  .demo-box{font-size:.73em}
}
</style>
</head>
<body>
<div class="container">
  <div class="left">
    <div style="font-size:3em;margin-bottom:14px"></div>
    <h1>Glamour Stock</h1>
    <p>Sistema de gestión para tu salón de belleza. Citas, servicios y clientes en un solo lugar.</p>
    <div class="features">
      <div class="feat"><div class="feat-icon"></div><div class="feat-text"><strong>Agenda de Citas</strong><span>Gestión fácil y rápida</span></div></div>
      <div class="feat"><div class="feat-icon"></div><div class="feat-text"><strong>Catálogo de Servicios</strong><span>Manicura, pestañas, cejas y más</span></div></div>
      <div class="feat"><div class="feat-icon"></div><div class="feat-text"><strong>Gestión de Clientes</strong><span>Historial y perfiles completos</span></div></div>
    </div>
  </div>

  <div class="right">
    <h2>Bienvenida </h2>
    <p>Inicia sesión para continuar</p>

    <?php if (!empty($error)): ?>
    <div class="alert-err"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label>Correo electrónico</label>
        <input type="email" name="correo" placeholder="correo@ejemplo.com" required>
      </div>
      <div class="form-group">
        <label>Contraseña</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn-login">Iniciar Sesión</button>
    </form>

    <div class="links">
      ¿No tienes cuenta? <a href="index.php?controller=auth&action=registro">Regístrate aquí</a>
    </div>

    <div class="demo-box">
      <strong> Cuentas de prueba (contraseña: <code>password</code>)</strong>
      <div class="demo-row"><span> Admin</span><span>admin@glamourstock.com</span></div>
      <div class="demo-row"><span> Empleada</span><span>empleada@glamourstock.com</span></div>
      <div class="demo-row"><span> Cliente</span><span>cliente@glamourstock.com</span></div>
    </div>
  </div>
</div>
</body>
</html>
