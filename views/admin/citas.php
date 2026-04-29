<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Citas – Glamour Stock</title>
<link rel="stylesheet" href="public/css/main.css">
</head>
<body>
<?php require_once __DIR__ . '/../_menu.php'; ?>
<div class="main">
  <div class="topbar">
    <div class="topbar-title">Gestión de Citas</div>
    <div class="topbar-right">
      <div class="avatar"><?= strtoupper(substr($usuario['nombre'],0,2)) ?></div>
    </div>
  </div>
  <div class="content">

    <form method="GET">
      <input type="hidden" name="controller" value="admin">
      <input type="hidden" name="action" value="citas">
      <div class="filter-bar">
        <select name="estado" onchange="this.form.submit()">
          <option value="">Todos los estados</option>
          <?php foreach(['pendiente','confirmada','completada','cancelada'] as $e): ?>
          <option value="<?=$e?>" <?= (isset($_GET['estado']) && $_GET['estado']===$e)?'selected':'' ?>><?= ucfirst($e) ?></option>
          <?php endforeach; ?>
        </select>
        <?php if (!empty($_GET['estado'])): ?>
        <a href="index.php?controller=admin&action=citas" style="padding:9px 12px;color:#7f8c8d;text-decoration:none">✕ Ver todas</a>
        <?php endif; ?>
      </div>
    </form>

    <div class="panel">
      <div class="panel-header">
        <div class="panel-title">Lista de Citas (<?= count($citas) ?>)</div>
      </div>
      <?php if (empty($citas)): ?>
      <div class="empty"><div style="font-size:3em"></div><p style="margin-top:12px">No hay citas</p></div>
      <?php else: ?>
      <div style="overflow-x:auto"><table>
        <thead>
          <tr><th>Cliente</th><th>Servicio</th><th>Fecha</th><th>Hora</th><th>Precio</th><th>Estado</th><th>Acciones</th></tr>
        </thead>
        <tbody>
        <?php foreach($citas as $c): ?>
        <tr>
          <td>
            <div style="font-weight:600"><?= htmlspecialchars($c['cliente_nombre']) ?></div>
            <div style="font-size:.8em;color:#aaa"><?= htmlspecialchars($c['cliente_correo']) ?></div>
          </td>
          <td><?= htmlspecialchars($c['servicio_nombre']) ?></td>
          <td><?= date('d/m/Y', strtotime($c['fecha'])) ?></td>
          <td><?= substr($c['hora'],0,5) ?></td>
          <td>$<?= number_format($c['precio'],0,',','.') ?></td>
          <td><span class="badge badge-<?= $c['estado'] ?>"><?= ucfirst($c['estado']) ?></span></td>
          <td>
            <div style="display:flex;gap:4px;flex-wrap:wrap">
              <?php if ($c['estado']==='pendiente'): ?>
              <button class="btn-accion btn-ok" onclick="cambiarEstado(<?=$c['id']?>,'confirmada')">✓ Confirmar</button>
              <?php endif; ?>
              <?php if (in_array($c['estado'],['pendiente','confirmada'])): ?>
              <button class="btn-accion btn-accion btn-editar" onclick="cambiarEstado(<?=$c['id']?>,'completada')">✅ Completar</button>
              <button class="btn-accion btn-cancel" onclick="cambiarEstado(<?=$c['id']?>,'cancelada')">✕ Cancelar</button>
              <?php endif; ?>
            </div>
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
function cambiarEstado(id, estado) {
  if (!confirm('¿Cambiar estado a ' + estado + '?')) return;
  const fd = new FormData();
  fd.append('accion','cambiar_estado'); fd.append('id',id); fd.append('estado',estado);
  fetch('index.php?controller=admin&action=apiCitas', {method:'POST',body:fd})
    .then(r=>r.json()).then(d=>{ if(d.ok) location.reload(); });
}
</script>
</body>
</html>
