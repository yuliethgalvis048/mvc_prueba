<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Agendar Cita – Glamour Stock</title>
<link rel="stylesheet" href="public/css/main.css">
</head>
<body>
<?php require_once __DIR__ . '/../_menu.php'; ?>
<div class="main">
  <div class="topbar">
    <div class="topbar-title">📅 Agendar Cita</div>
    <div class="topbar-right">
      <div class="avatar"><?= strtoupper(substr($usuario['nombre'],0,2)) ?></div>
    </div>
  </div>
  <div class="content">
    <div class="panel" style="max-width:580px">
      <div class="panel-header"><div class="panel-title">Nueva Cita</div></div>
      <div style="padding:24px">
        <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
        <div class="alert alert-success">✅ <?= htmlspecialchars($success) ?> <a href="index.php?controller=cliente&action=index" style="color:var(--primary);font-weight:700">Ver mis citas →</a></div>
        <?php endif; ?>

        <form method="POST">
          <div class="form-grid">
            <div class="fg full">
              <label>Servicio</label>
              <select name="servicio_id" required>
                <option value="">-- Selecciona un servicio --</option>
                <?php foreach($servicios as $s): ?>
                <option value="<?= $s['id'] ?>"
                  <?= (($_GET['servicio_id']??'')==$s['id'])?'selected':'' ?>>
                  <?= htmlspecialchars($s['nombre']) ?> – $<?= number_format($s['precio'],0,',','.') ?> (<?= $s['duracion'] ?> min)
                </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="fg">
              <label>Fecha</label>
              <input type="date" name="fecha" min="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="fg">
              <label>Hora</label>
              <select name="hora" required>
                <option value="">-- Selecciona --</option>
                <?php
                $horas = ['08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30',
                          '12:00','12:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00'];
                foreach($horas as $h): ?>
                <option value="<?= $h ?>"><?= $h ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="fg full">
              <label>Comentarios (opcional)</label>
              <textarea name="comentarios" rows="3" placeholder="Alguna indicación especial..."></textarea>
            </div>
          </div>
          <div style="margin-top:20px">
            <button type="submit" class="btn-primary" style="width:100%;padding:13px;font-size:.95em">Confirmar Cita</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
