<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Portal Empleada – Glamour Stock</title>
<link rel="stylesheet" href="public/css/main.css">
</head>
<body>
<?php require_once __DIR__ . '/../_menu.php'; ?>
<div class="main">
  <div class="topbar">
    <div class="topbar-title">Mis Citas de Hoy</div>
    <div class="topbar-right">
      <span style="font-size:.85em;color:#7f8c8d">Hola, <?= htmlspecialchars($usuario['nombre']) ?> </span>
      <div class="avatar"><?= strtoupper(substr($usuario['nombre'],0,2)) ?></div>
    </div>
  </div>
  <div class="content">
    <div class="kpis">
      <div class="kpi pink"><div class="kpi-icon"></div><div><div class="kpi-label">Citas hoy</div><div class="kpi-value"><?= count($citasHoy) ?></div></div></div>
      <div class="kpi orange"><div class="kpi-icon"></div><div><div class="kpi-label">Citas este mes</div><div class="kpi-value"><?= $totalMes ?></div></div></div>
    </div>

    <div class="panel">
      <div class="panel-header">
        <div class="panel-title">Agenda del día – <?= date('d/m/Y') ?></div>
      </div>
      <?php if (empty($citasHoy)): ?>
      <div class="empty"><div style="font-size:3em"></div><p style="margin-top:12px">No hay citas programadas para hoy</p></div>
      <?php else: ?>
      <div style="overflow-x:auto"><table>
        <thead><tr><th>Hora</th><th>Cliente</th><th>Servicio</th><th>Estado</th><th>Acción</th></tr></thead>
        <tbody>
        <?php foreach($citasHoy as $c): ?>
        <tr>
          <td><strong><?= substr($c['hora'],0,5) ?></strong></td>
          <td><?= htmlspecialchars($c['cliente_nombre']) ?></td>
          <td><?= htmlspecialchars($c['servicio_nombre']) ?></td>
          <td><span class="badge badge-<?= $c['estado'] ?>"><?= ucfirst($c['estado']) ?></span></td>
          <td>
            <?php if ($c['estado']==='confirmada'): ?>
            <button class="btn-accion btn-ok" onclick="completar(<?=$c['id']?>)"> Completar</button>
            <?php elseif($c['estado']==='pendiente'): ?>
            <button class="btn-accion btn-editar" onclick="confirmar(<?=$c['id']?>)"> Confirmar</button>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table></div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
function cambiarEstado(id,estado){
  const fd=new FormData();fd.append('accion','cambiar_estado');fd.append('id',id);fd.append('estado',estado);
  fetch('index.php?controller=admin&action=apiCitas',{method:'POST',body:fd})
    .then(r=>r.json()).then(d=>{if(d.ok)location.reload()});
}
function completar(id){if(confirm('¿Marcar como completada?'))cambiarEstado(id,'completada')}
function confirmar(id){if(confirm('¿Confirmar esta cita?'))cambiarEstado(id,'confirmada')}
</script>
</body>
</html>
