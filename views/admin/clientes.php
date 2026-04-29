<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Clientes – Glamour Stock</title>
<link rel="stylesheet" href="public/css/main.css">
</head>
<body>
<?php require_once __DIR__ . '/../_menu.php'; ?>
<div class="main">
  <div class="topbar">
    <div class="topbar-title"> Gestión de Clientes</div>
    <?php if($usuario['rol']==='admin'): ?>
    <div class="topbar-right">
      <button class="btn-primary" onclick="abrirModal()">+ Nuevo Cliente</button>
      <div class="avatar"><?= strtoupper(substr($usuario['nombre'],0,2)) ?></div>
    </div>
    <?php endif; ?>
  </div>
  <div class="content">
    <div class="kpis">
      <div class="kpi pink"><div class="kpi-icon"></div><div><div class="kpi-label">Total Clientes</div><div class="kpi-value"><?= $total ?></div></div></div>
    </div>

    <form method="GET">
      <input type="hidden" name="controller" value="admin">
      <input type="hidden" name="action" value="clientes">
      <div class="filter-bar">
        <input type="text" name="buscar" placeholder=" Buscar por nombre, correo o teléfono..." value="<?= htmlspecialchars($busqueda) ?>" style="flex:1">
        <button type="submit">Buscar</button>
        <?php if ($busqueda): ?><a href="index.php?controller=admin&action=clientes" style="padding:9px 12px;color:#7f8c8d;text-decoration:none">✕ Limpiar</a><?php endif; ?>
      </div>
    </form>

    <div class="panel">
      <div class="panel-header"><div class="panel-title">Lista de Clientes (<?= count($clientes) ?>)</div></div>
      <?php if (empty($clientes)): ?>
      <div class="empty"><div style="font-size:3em"></div><p style="margin-top:12px">No hay clientes</p></div>
      <?php else: ?>
      <div style="overflow-x:auto"><table>
        <thead><tr><th>Cliente</th><th>Correo</th><th>Teléfono</th><th>Citas</th><th>Registro</th><th>Acciones</th></tr></thead>
        <tbody>
        <?php foreach($clientes as $cl): ?>
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              <div class="avatar" style="background:var(--primary)"><?= strtoupper(substr($cl['nombre'],0,2)) ?></div>
              <div style="font-weight:600"><?= htmlspecialchars($cl['nombre']) ?></div>
            </div>
          </td>
          <td><?= htmlspecialchars($cl['correo']) ?></td>
          <td><?= htmlspecialchars($cl['telefono']??'—') ?></td>
          <td><span style="font-weight:700;color:var(--primary)"><?= $cl['total_citas'] ?></span></td>
          <td><?= date('d/m/Y', strtotime($cl['fecha_registro'])) ?></td>
          <td>
            <div style="display:flex;gap:4px">
              <button class="btn-accion btn-ver" onclick="verHistorial(<?= $cl['id'] ?>,'<?= htmlspecialchars(addslashes($cl['nombre'])) ?>')">👁️ Historial</button>
              <?php if($usuario['rol']==='admin'): ?>
              <button class="btn-accion btn-eliminar" onclick="eliminarCliente(<?= $cl['id'] ?>,'<?= htmlspecialchars(addslashes($cl['nombre'])) ?>')">🗑️</button>
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

<!-- MODAL NUEVO CLIENTE -->
<div class="overlay" id="overlay">
  <div class="modal">
    <button class="modal-close" onclick="cerrarModal()">✕</button>
    <h2>+ Nuevo Cliente</h2>
    <div id="msg-cliente"></div>
    <div class="form-grid">
      <div class="fg full"><label>Nombre completo</label><input type="text" id="cl-nombre" placeholder="Nombre"></div>
      <div class="fg full"><label>Correo</label><input type="email" id="cl-correo" placeholder="correo@ejemplo.com"></div>
      <div class="fg"><label>Teléfono</label><input type="tel" id="cl-tel" placeholder="3XX XXX XXXX"></div>
      <div class="fg"><label>Contraseña</label><input type="password" id="cl-pass" placeholder="Contraseña"></div>
    </div>
    <div class="modal-actions">
      <button class="btn-secondary" onclick="cerrarModal()">Cancelar</button>
      <button class="btn-primary" onclick="crearCliente()">Crear Cliente</button>
    </div>
  </div>
</div>

<!-- MODAL HISTORIAL -->
<div class="overlay" id="overlay-hist">
  <div class="modal" style="max-width:700px">
    <button class="modal-close" onclick="cerrarHist()">✕</button>
    <h2 id="hist-titulo">Historial</h2>
    <div id="hist-body"><p style="text-align:center;padding:20px">Cargando...</p></div>
    <div class="modal-actions"><button class="btn-secondary" onclick="cerrarHist()">Cerrar</button></div>
  </div>
</div>

<script>
function abrirModal(){document.getElementById('overlay').classList.add('open')}
function cerrarModal(){document.getElementById('overlay').classList.remove('open')}
function cerrarHist(){document.getElementById('overlay-hist').classList.remove('open')}

function crearCliente(){
  const fd=new FormData();
  fd.append('accion','crear');
  fd.append('nombre',document.getElementById('cl-nombre').value);
  fd.append('correo',document.getElementById('cl-correo').value);
  fd.append('telefono',document.getElementById('cl-tel').value);
  fd.append('password',document.getElementById('cl-pass').value);
  fetch('index.php?controller=admin&action=apiClientes',{method:'POST',body:fd})
    .then(r=>r.json()).then(d=>{
      const m=document.getElementById('msg-cliente');
      if(d.ok){m.innerHTML='<div class="alert-modal alert-ok">Cliente creado exitosamente.</div>';setTimeout(()=>location.reload(),1200)}
      else{m.innerHTML='<div class="alert-modal alert-err">'+(d.error||'Error')+'</div>'}
    });
}

function eliminarCliente(id,nombre){
  if(!confirm('¿Eliminar cliente '+nombre+'?'))return;
  const fd=new FormData();fd.append('accion','eliminar');fd.append('id',id);
  fetch('index.php?controller=admin&action=apiClientes',{method:'POST',body:fd})
    .then(r=>r.json()).then(d=>{if(d.ok)location.reload()});
}

function verHistorial(id,nombre){
  document.getElementById('hist-titulo').textContent='Historial de '+nombre;
  document.getElementById('overlay-hist').classList.add('open');
  fetch('index.php?controller=admin&action=apiClientes&accion=historial&id='+id)
    .then(r=>r.json()).then(citas=>{
      if(!citas.length){document.getElementById('hist-body').innerHTML='<div class="empty">Sin citas registradas</div>';return;}
      let h='<div style="overflow-x:auto"><table><thead><tr><th>Servicio</th><th>Fecha</th><th>Hora</th><th>Estado</th></tr></thead><tbody>';
      citas.forEach(c=>{h+=`<tr><td>${c.servicio_nombre}</td><td>${c.fecha}</td><td>${c.hora.slice(0,5)}</td><td><span class="badge badge-${c.estado}">${c.estado}</span></td></tr>`});
      h+='</tbody></table></div>';
      document.getElementById('hist-body').innerHTML=h;
    });
}
</script>
</body>
</html>
