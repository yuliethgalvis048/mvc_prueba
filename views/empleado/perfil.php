<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Mi Perfil – Glamour Stock</title>
<link rel="stylesheet" href="public/css/main.css">
</head>
<body>
<?php require_once __DIR__ . '/../_menu.php'; ?>
<div class="main">
  <div class="topbar">
    <div class="topbar-title"> Mi Perfil</div>
    <div class="topbar-right">
      <div class="avatar"><?= strtoupper(substr($usuario['nombre'],0,2)) ?></div>
    </div>
  </div>
  <div class="content">
    <div class="panel" style="max-width:500px">
      <div class="panel-header"><div class="panel-title">Información personal</div></div>
      <div style="padding:24px">
        <?php if (!empty($error)): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
        <?php if (!empty($success)): ?><div class="alert alert-success"> <?= $success ?></div><?php endif; ?>
        <form method="POST">
          <div class="fg" style="margin-bottom:14px">
            <label>Nombre</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
          </div>
          <div class="fg" style="margin-bottom:14px">
            <label>Correo (no modificable)</label>
            <input type="email" value="<?= htmlspecialchars($usuario['correo']) ?>" disabled style="background:#f9f9f9">
          </div>
          <div class="fg" style="margin-bottom:20px">
            <label>Teléfono</label>
            <input type="tel" name="telefono" value="<?= htmlspecialchars($usuario['telefono']??'') ?>">
          </div>
          <button type="submit" class="btn-primary">Guardar cambios</button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
