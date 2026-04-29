<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Dashboard – Glamour Stock</title>
<link rel="stylesheet" href="public/css/main.css">
<style>
.panels{display:grid;grid-template-columns:2fr 1fr;gap:20px}
.top-item{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #f0e8ec}
.top-item:last-child{border:0}
.act-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;padding:16px}
.act-btn{display:flex;flex-direction:column;align-items:center;gap:6px;padding:16px 10px;border-radius:10px;text-decoration:none;font-size:.82em;font-weight:600;transition:transform .2s,box-shadow .2s;text-align:center}
.act-btn:hover{transform:translateY(-2px);box-shadow:0 5px 14px rgba(0,0,0,.12)}
.act-btn .ico{font-size:1.7em}
.a1{background:#fce4ec;color:#880e4f}
.a2{background:#e8eaf6;color:#283593}
.a3{background:#e8f5e9;color:#2e7d32}
.a4{background:#fff3e0;color:#e65100}
@media(max-width:900px){.panels{grid-template-columns:1fr}}
@media(max-width:480px){.act-grid{grid-template-columns:1fr 1fr}.act-btn{padding:12px 8px;font-size:.78em}}
</style>
</head>
<body>
<?php require_once __DIR__ . '/../_menu.php'; ?>
<div class="main">
  <div class="topbar">
    <div class="topbar-title"> Dashboard</div>
    <div class="topbar-right">
      <span style="font-size:.85em;color:#7f8c8d">Hola, <?= htmlspecialchars($usuario['nombre']) ?> </span>
      <div class="avatar"><?= strtoupper(substr($usuario['nombre'],0,2)) ?></div>
    </div>
  </div>

  <div class="content">
    <div class="kpis">
      <div class="kpi pink"><div class="kpi-icon"></div><div><div class="kpi-label">Total Citas</div><div class="kpi-value"><?= $totalCitas ?></div><div class="kpi-sub"><?= $citasHoy ?> hoy</div></div></div>
      <div class="kpi orange"><div class="kpi-icon"></div><div><div class="kpi-label">Pendientes</div><div class="kpi-value"><?= $citasPendientes ?></div><div class="kpi-sub">por confirmar</div></div></div>
      <div class="kpi green"><div class="kpi-icon"></div><div><div class="kpi-label">Ingresos Potenciales</div><div class="kpi-value">$<?= number_format($ingresosPotenciales,0,',','.') ?></div><div class="kpi-sub">COP</div></div></div>
      <div class="kpi blue"><div class="kpi-icon"></div><div><div class="kpi-label">Clientes</div><div class="kpi-value"><?= $totalClientes ?></div><div class="kpi-sub"><?= $totalEmpleados ?> empleadas</div></div></div>
      <div class="kpi pink"><div class="kpi-icon"></div><div><div class="kpi-label">Servicios Activos</div><div class="kpi-value"><?= $totalServicios ?></div></div></div>
    </div>

    <div class="panels">
      <div>
        <div class="panel">
          <div class="panel-header">
            <div class="panel-title"> Próximas Citas</div>
            <a href="index.php?controller=admin&action=citas" style="font-size:.82em;color:var(--primary);text-decoration:none">Ver todas →</a>
          </div>
          <?php if (empty($proximasCitas)): ?>
          <div class="empty"><div style="font-size:2.5em"></div><p style="margin-top:10px">No hay citas próximas</p></div>
          <?php else: ?>
          <table>
            <thead><tr><th>Cliente</th><th>Servicio</th><th>Fecha</th><th>Hora</th><th>Estado</th><th>Acción</th></tr></thead>
            <tbody>
            <?php foreach($proximasCitas as $c): ?>
            <tr>
              <td><strong><?= htmlspecialchars($c['cliente_nombre']) ?></strong></td>
              <td><?= htmlspecialchars($c['servicio_nombre']) ?></td>
              <td><?= date('d/m/Y', strtotime($c['fecha'])) ?></td>
              <td><?= substr($c['hora'],0,5) ?></td>
              <td><span class="badge badge-<?= $c['estado'] ?>"><?= ucfirst($c['estado']) ?></span></td>
              <td>
                <?php if ($c['estado']==='pendiente'): ?>
                <button class="btn-accion btn-ok" onclick="cambiarEstado(<?= $c['id'] ?>,'confirmada',this)">✓</button>
                <button class="btn-accion btn-cancel" onclick="cambiarEstado(<?= $c['id'] ?>,'cancelada',this)">✕</button>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
          <?php endif; ?>
        </div>

        <?php if (!empty($serviciosTop)): ?>
        <div class="panel">
          <div class="panel-header"><div class="panel-title"> Servicios más solicitados</div></div>
          <table>
            <thead><tr><th>Servicio</th><th>Citas</th><th>Precio</th></tr></thead>
            <tbody>
            <?php foreach($serviciosTop as $s): ?>
            <tr>
              <td><?= htmlspecialchars($s['nombre']) ?></td>
              <td><strong style="color:var(--primary)"><?= $s['total'] ?></strong></td>
              <td>$<?= number_format($s['precio'],0,',','.') ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
      </div>

      <div>
        <div class="panel">
          <div class="panel-header"><div class="panel-title"> Acciones rápidas</div></div>
          <div class="act-grid">
            <a href="index.php?controller=admin&action=citas" class="act-btn a1"><div class="ico"></div>Ver Citas</a>
            <a href="index.php?controller=admin&action=clientes" class="act-btn a2"><div class="ico"></div>Clientes</a>
            <a href="index.php?controller=admin&action=servicios" class="act-btn a3"><div class="ico"></div>Servicios</a>
            <a href="index.php?controller=admin&action=empleados" class="act-btn a4"><div class="ico"></div>Empleadas</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function cambiarEstado(id, estado, btn) {
  if (!confirm('¿Cambiar estado a ' + estado + '?')) return;
  const fd = new FormData();
  fd.append('accion','cambiar_estado'); fd.append('id',id); fd.append('estado',estado);
  fetch('index.php?controller=admin&action=apiCitas', {method:'POST',body:fd})
    .then(r=>r.json()).then(d=>{ if(d.ok) location.reload(); });
}
</script>
</body>
</html>
