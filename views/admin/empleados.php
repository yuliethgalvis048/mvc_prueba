<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Empleadas – Glamour Stock</title>
<link rel="stylesheet" href="public/css/main.css">
</head>
<body>
<?php require_once __DIR__ . '/../_menu.php'; ?>
<div class="main">
  <div class="topbar">
    <div class="topbar-title">Gestión de Empleadas</div>
    <div class="topbar-right">
      <button class="btn-primary" onclick="abrirModal()">+ Nueva Empleada</button>
      <div class="avatar"><?= strtoupper(substr($usuario['nombre'],0,2)) ?></div>
    </div>
  </div>
  <div class="content">
    <form method="GET">
      <input type="hidden" name="controller" value="admin">
      <input type="hidden" name="action" value="empleados">
      <div class="filter-bar">
        <input type="text" name="buscar" placeholder=" Buscar por nombre o correo..." value="<?= htmlspecialchars($busqueda ?? '') ?>" style="flex:1">
        <button type="submit">Buscar</button>
      </div>
    </form>

    <div class="panel">
      <div class="panel-header"><div class="panel-title">Personal del Salón (<?= count($empleados) ?>)</div></div>
      <?php if (empty($empleados)): ?>
      <div class="empty"><div style="font-size:3em"></div><p style="margin-top:12px">No hay personal registrado</p></div>
      <?php else: ?>
      <div style="overflow-x:auto"><table>
        <thead><tr><th>Nombre</th><th>Correo</th><th>Teléfono</th><th>Rol</th><th>Citas Asignadas</th><th>Registro</th><th>Acción</th></tr></thead>
        <tbody>
        <?php foreach($empleados as $e): ?>
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              <div class="avatar" style="background:<?= $e['rol']==='admin'?'#e67e22':'var(--primary)' ?>"><?= strtoupper(substr($e['nombre'],0,2)) ?></div>
              <div style="font-weight:600"><?= htmlspecialchars($e['nombre']) ?></div>
            </div>
          </td>
          <td><?= htmlspecialchars($e['correo']) ?></td>
          <td><?= htmlspecialchars($e['telefono']??'—') ?></td>
          <td><span class="badge badge-<?= $e['rol'] ?>"><?= ucfirst($e['rol']) ?></span></td>
          <td><strong style="color:var(--primary)"><?= $e['citas_asignadas'] ?></strong></td>
          <td><?= date('d/m/Y', strtotime($e['fecha_registro'])) ?></td>
          <td>
            <?php if ($e['id'] != $usuario['id']): ?>
            <button class="btn-accion btn-eliminar" onclick="eliminar(<?=$e['id']?>,'<?=htmlspecialchars(addslashes($e['nombre']))?>')">🗑️</button>
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

<!-- MODAL -->
<div class="overlay" id="overlay">
  <div class="modal">
    <button class="modal-close" onclick="cerrarModal()">✕</button>
    <h2>+ Nueva Empleada</h2>
    <div id="msg-emp"></div>
    <div class="form-grid">
      <div class="fg full"><label>Nombre completo</label><input type="text" id="e-nombre" placeholder="Nombre completo"></div>
      <div class="fg full"><label>Correo</label><input type="email" id="e-correo" placeholder="correo@ejemplo.com"></div>
      <div class="fg"><label>Teléfono</label><input type="tel" id="e-tel" placeholder="3XX XXX XXXX"></div>
      <div class="fg"><label>Contraseña</label><input type="password" id="e-pass" placeholder="Contraseña"></div>
      <div class="fg full"><label>Rol</label>
        <select id="e-rol"><option value="empleado">Empleada</option><option value="admin">Admin</option></select>
      </div>
    </div>
    <div class="modal-actions">
      <button class="btn-secondary" onclick="cerrarModal()">Cancelar</button>
      <button class="btn-primary" onclick="crear()">Crear</button>
    </div>
  </div>
</div>

<script>
function abrirModal(){document.getElementById('overlay').classList.add('open')}
function cerrarModal(){document.getElementById('overlay').classList.remove('open')}

function crear(){
  const fd=new FormData();
  fd.append('accion','crear');
  ['nombre','correo','telefono','password','rol'].forEach(f=>{
    fd.append(f,document.getElementById('e-'+f).value);
  });
  fetch('index.php?controller=admin&action=apiEmpleados',{method:'POST',body:fd})
    .then(r=>r.json()).then(d=>{
      const m=document.getElementById('msg-emp');
      if(d.ok){m.innerHTML='<div class="alert-modal alert-ok">Empleada creada.</div>';setTimeout(()=>location.reload(),1200)}
      else{m.innerHTML='<div class="alert-modal alert-err">'+(d.error||'Error')+'</div>'}
    });
}
function eliminar(id,nombre){
  if(!confirm('¿Eliminar '+nombre+'?'))return;
  const fd=new FormData();fd.append('accion','eliminar');fd.append('id',id);
  fetch('index.php?controller=admin&action=apiEmpleados',{method:'POST',body:fd})
    .then(r=>r.json()).then(d=>{if(d.ok)location.reload()});
}
</script>
</body>
</html>
