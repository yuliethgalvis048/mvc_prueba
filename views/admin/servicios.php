<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Servicios – Glamour Stock</title>
<link rel="stylesheet" href="public/css/main.css">
</head>
<body>
<?php require_once __DIR__ . '/../_menu.php'; ?>
<div class="main">
  <div class="topbar">
    <div class="topbar-title"> Gestión de Servicios</div>
    <div class="topbar-right">
      <button class="btn-primary" onclick="abrirModal()">+ Nuevo Servicio</button>
      <div class="avatar"><?= strtoupper(substr($usuario['nombre'],0,2)) ?></div>
    </div>
  </div>
  <div class="content">
    <div class="panel">
      <div class="panel-header"><div class="panel-title">Catálogo de Servicios (<?= count($servicios) ?>)</div></div>
      <?php if (empty($servicios)): ?>
      <div class="empty"><div style="font-size:3em"></div><p style="margin-top:12px">No hay servicios</p></div>
      <?php else: ?>
      <div style="overflow-x:auto"><table>
        <thead><tr><th>Nombre</th><th>Categoría</th><th>Descripción</th><th>Precio</th><th>Duración</th><th>Estado</th><th>Acciones</th></tr></thead>
        <tbody>
        <?php foreach($servicios as $s): ?>
        <tr>
          <td><strong><?= htmlspecialchars($s['nombre']) ?></strong></td>
          <td><?= htmlspecialchars($s['categoria']??'—') ?></td>
          <td style="max-width:200px;font-size:.82em;color:#666"><?= htmlspecialchars($s['descripcion']??'') ?></td>
          <td><strong style="color:var(--primary)">$<?= number_format($s['precio'],0,',','.') ?></strong></td>
          <td><?= $s['duracion'] ?> min</td>
          <td>
            <span class="badge" style="background:<?= $s['activo']?'#d1e7dd;color:#0f5132':'#f8d7da;color:#842029' ?>">
              <?= $s['activo']?'Activo':'Inactivo' ?>
            </span>
          </td>
          <td>
            <div style="display:flex;gap:4px">
              <button class="btn-accion btn-editar" onclick="editarServicio(<?= $s['id'] ?>)">✏️ Editar</button>
              <button class="btn-accion btn-eliminar" onclick="eliminar(<?= $s['id'] ?>,'<?= htmlspecialchars(addslashes($s['nombre'])) ?>')">🗑️</button>
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

<!-- MODAL -->
<div class="overlay" id="overlay">
  <div class="modal">
    <button class="modal-close" onclick="cerrarModal()">✕</button>
    <h2 id="modal-titulo">+ Nuevo Servicio</h2>
    <input type="hidden" id="s-id">
    <div id="msg-serv"></div>
    <div class="form-grid">
      <div class="fg full"><label>Nombre del servicio</label><input type="text" id="s-nombre" placeholder="Ej: Manicura Clásica"></div>
      <div class="fg full"><label>Descripción</label><textarea id="s-desc" rows="2" placeholder="Descripción breve..."></textarea></div>
      <div class="fg"><label>Precio (COP)</label><input type="number" id="s-precio" placeholder="20000"></div>
      <div class="fg"><label>Duración (minutos)</label><input type="number" id="s-dur" placeholder="40"></div>
      <div class="fg full"><label>Categoría</label>
        <select id="s-cat">
          <option value="Uñas">Uñas</option>
          <option value="Cejas"> Cejas</option>
          <option value="Pestañas">Pestañas</option>
          <option value="Spa"> Spa</option>
          <option value="Otro">Otro</option>
        </select>
      </div>
    </div>
    <div class="modal-actions">
      <button class="btn-secondary" onclick="cerrarModal()">Cancelar</button>
      <button class="btn-primary" onclick="guardar()">Guardar</button>
    </div>
  </div>
</div>

<script>
function abrirModal(){
  document.getElementById('modal-titulo').textContent='+ Nuevo Servicio';
  document.getElementById('s-id').value='';
  ['nombre','desc','precio','dur'].forEach(f=>document.getElementById('s-'+f).value='');
  document.getElementById('overlay').classList.add('open');
}
function cerrarModal(){document.getElementById('overlay').classList.remove('open')}

function editarServicio(id){
  fetch('index.php?controller=admin&action=apiServicios&accion=get&id='+id)
    .then(r=>r.json()).then(s=>{
      document.getElementById('modal-titulo').textContent=' Editar Servicio';
      document.getElementById('s-id').value=s.id;
      document.getElementById('s-nombre').value=s.nombre;
      document.getElementById('s-desc').value=s.descripcion||'';
      document.getElementById('s-precio').value=s.precio;
      document.getElementById('s-dur').value=s.duracion;
      document.getElementById('s-cat').value=s.categoria||'Uñas';
      document.getElementById('overlay').classList.add('open');
    });
}

function guardar(){
  const id=document.getElementById('s-id').value;
  const fd=new FormData();
  fd.append('accion',id?'editar':'crear');
  if(id) fd.append('id',id);
  fd.append('nombre',document.getElementById('s-nombre').value);
  fd.append('descripcion',document.getElementById('s-desc').value);
  fd.append('precio',document.getElementById('s-precio').value);
  fd.append('duracion',document.getElementById('s-dur').value);
  fd.append('categoria',document.getElementById('s-cat').value);
  fetch('index.php?controller=admin&action=apiServicios',{method:'POST',body:fd})
    .then(r=>r.json()).then(d=>{
      if(d.ok){setTimeout(()=>location.reload(),800)}
      else document.getElementById('msg-serv').innerHTML='<div class="alert-modal alert-err">Error al guardar</div>';
    });
}
function eliminar(id,nombre){
  if(!confirm('¿Eliminar servicio '+nombre+'?'))return;
  const fd=new FormData();fd.append('accion','eliminar');fd.append('id',id);
  fetch('index.php?controller=admin&action=apiServicios',{method:'POST',body:fd})
    .then(r=>r.json()).then(d=>{if(d.ok)location.reload()});
}
</script>
</body>
</html>
