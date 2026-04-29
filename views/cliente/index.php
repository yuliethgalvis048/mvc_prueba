<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Mis Citas – Glamour Stock</title>
<link rel="stylesheet" href="public/css/main.css">
</head>
<body>
<?php require_once __DIR__ . '/../_menu.php'; ?>
<div class="main">
  <div class="topbar">
    <div class="topbar-title">📋 Mis Citas</div>
    <div class="topbar-right">
      <a href="index.php?controller=cliente&action=agendar" class="btn-primary">+ Agendar Cita</a>
      <div class="avatar"><?= strtoupper(substr($usuario['nombre'],0,2)) ?></div>
    </div>
  </div>
  <div class="content">
    <?php
    $proximas   = array_filter($citas, fn($c) => in_array($c['estado'],['pendiente','confirmada']));
    $historial  = array_filter($citas, fn($c) => in_array($c['estado'],['completada','cancelada']));
    ?>

    <div class="kpis">
      <div class="kpi pink"><div class="kpi-icon">📅</div><div><div class="kpi-label">Total Citas</div><div class="kpi-value"><?= count($citas) ?></div></div></div>
      <div class="kpi orange"><div class="kpi-icon">⏳</div><div><div class="kpi-label">Próximas</div><div class="kpi-value"><?= count($proximas) ?></div></div></div>
      <div class="kpi green"><div class="kpi-icon">✅</div><div><div class="kpi-label">Completadas</div><div class="kpi-value"><?= count(array_filter($citas,fn($c)=>$c['estado']==='completada')) ?></div></div></div>
    </div>

    <?php if (!empty($proximas)): ?>
    <div class="panel">
      <div class="panel-header"><div class="panel-title">📅 Próximas Citas</div></div>
      <div style="overflow-x:auto"><table>
        <thead><tr><th>Servicio</th><th>Fecha</th><th>Hora</th><th>Precio</th><th>Estado</th><th>Acción</th></tr></thead>
        <tbody>
        <?php foreach($proximas as $c): ?>
        <tr>
          <td>
            <div style="font-weight:600"><?= htmlspecialchars($c['servicio_nombre']) ?></div>
            <div style="font-size:.8em;color:#aaa"><?= htmlspecialchars($c['categoria']??'') ?> · <?= $c['duracion'] ?> min</div>
          </td>
          <td><?= date('d/m/Y', strtotime($c['fecha'])) ?></td>
          <td><?= substr($c['hora'],0,5) ?></td>
          <td>$<?= number_format($c['precio'],0,',','.') ?></td>
          <td><span class="badge badge-<?= $c['estado'] ?>"><?= ucfirst($c['estado']) ?></span></td>
          <td>
            <?php if ($c['estado']==='pendiente'): ?>
            <a href="index.php?controller=cliente&action=cancelarCita&id=<?= $c['id'] ?>"
               class="btn-accion btn-cancel"
               onclick="return confirm('¿Cancelar esta cita?')">✕ Cancelar</a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table></div>
    </div>
    <?php endif; ?>

    <?php if (!empty($historial)): ?>
    <div class="panel">
      <div class="panel-header"><div class="panel-title">🗂️ Historial</div></div>
      <div style="overflow-x:auto"><table>
        <thead><tr><th>Servicio</th><th>Fecha</th><th>Hora</th><th>Precio</th><th>Estado</th></tr></thead>
        <tbody>
        <?php foreach($historial as $c): ?>
        <tr>
          <td><?= htmlspecialchars($c['servicio_nombre']) ?></td>
          <td><?= date('d/m/Y', strtotime($c['fecha'])) ?></td>
          <td><?= substr($c['hora'],0,5) ?></td>
          <td>$<?= number_format($c['precio'],0,',','.') ?></td>
          <td><span class="badge badge-<?= $c['estado'] ?>"><?= ucfirst($c['estado']) ?></span></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table></div>
    </div>
    <?php endif; ?>

    <?php if (empty($citas)): ?>
    <div class="panel">
      <div class="empty">
        <div style="font-size:3em">📅</div>
        <p style="margin-top:12px;font-size:1.05em">No tienes citas registradas</p>
        <a href="index.php?controller=cliente&action=agendar" class="btn-primary" style="display:inline-block;margin-top:16px;text-decoration:none">Agendar mi primera cita</a>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
