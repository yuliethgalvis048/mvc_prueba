<?php
if (!isset($usuario)) $usuario = Auth::usuarioActual();
$isAdmin    = ($usuario['rol'] ?? '') === 'admin';
$isEmpleado = ($usuario['rol'] ?? '') === 'empleado';
$ctrl       = $_GET['controller'] ?? '';
$action     = $_GET['action']     ?? '';
?>
<style>
:root{
  --primary:#c0637e;
--primary-dark:#a5506a;
--secondary:#3d2b3d;
--accent:#f9a8c0;--sidebar-w:260px}
.sidebar{width:var(--sidebar-w);
background:var(--secondary);
color:#ecf0f1;display:flex;
flex-direction:column;
position:fixed;
top:0;
left:0;
height:100vh;overflow-y:auto;z-index:300;transition:transform .3s ease}
.sidebar-logo{padding:22px 18px;border-bottom:1px solid rgba(255,255,255,.1)}
.sidebar-logo h2{font-size:1.05em;color:var(--accent)}
.sidebar-logo p{font-size:.72em;color:#95a5a6;margin-top:3px}
.sidebar-nav{flex:1;padding:8px 0}
.nav-section{padding:8px 18px 4px;font-size:.7em;text-transform:uppercase;letter-spacing:1px;color:#7f8c8d}
.sidebar-nav a{display:flex;align-items:center;gap:10px;padding:12px 18px;color:#bdc3c7;text-decoration:none;font-size:.9em;transition:all .2s}
.sidebar-nav a:hover,.sidebar-nav a.active{background:rgba(192,99,126,.2);color:var(--accent);border-right:3px solid var(--primary)}
.sidebar-footer{padding:14px 18px;border-top:1px solid rgba(255,255,255,.1);font-size:.82em;color:#7f8c8d}
.main{margin-left:var(--sidebar-w)}
.hamburger{display:none;position:fixed;top:11px;left:11px;z-index:400;background:var(--primary);border:none;border-radius:8px;width:42px;height:42px;cursor:pointer;flex-direction:column;align-items:center;justify-content:center;gap:5px;box-shadow:0 3px 12px rgba(192,99,126,.45);padding:0}
.hamburger span{display:block;width:22px;height:2px;background:white;border-radius:2px;transition:all .3s}
.hamburger.is-open span:nth-child(1){transform:translateY(7px) rotate(45deg)}
.hamburger.is-open span:nth-child(2){opacity:0}
.hamburger.is-open span:nth-child(3){transform:translateY(-7px) rotate(-45deg)}
.sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.52);z-index:250}
.sidebar-overlay.open{display:block}
@media(max-width:768px){
  .sidebar{transform:translateX(-100%)}
  .sidebar.open{transform:translateX(0)}
  .main{margin-left:0 !important}
  .hamburger{display:flex}
  .topbar{padding-left:64px !important}
  .kpis{grid-template-columns:1fr 1fr !important}
  .form-grid{grid-template-columns:1fr !important}
  .fg.full{grid-column:1 !important}
  .filter-bar{flex-direction:column !important}
  .filter-bar input,.filter-bar select,.filter-bar button{width:100% !important}
  .topbar-right span{display:none}
  .panels{grid-template-columns:1fr !important}
  .content{padding:14px !important}
}
@media(max-width:480px){
  .kpis{grid-template-columns:1fr !important}
  .topbar-title{font-size:.92em}
}
</style>

<button class="hamburger" id="gs-hamburger" onclick="gsToggleSidebar()" aria-label="Abrir menú">
  <span></span><span></span><span></span>
</button>
<div class="sidebar-overlay" id="gs-overlay" onclick="gsToggleSidebar()"></div>

<aside class="sidebar" id="gs-sidebar">
  <div class="sidebar-logo">
    <h2>&#128133; Glamour Stock</h2>
    <p><?php
      if ($isAdmin) echo 'Panel de Administración';
      elseif ($isEmpleado) echo 'Portal Empleada';
      else echo 'Portal Cliente';
    ?></p>
  </div>
  <nav class="sidebar-nav">
    <?php if ($isAdmin || $isEmpleado): ?>
      <div class="nav-section">PRINCIPAL</div>
      <a href="index.php?controller=admin&action=dashboard" class="<?= ($ctrl==='admin'&&$action==='dashboard')?'active':'' ?>" onclick="gsClose()">&#128202; Dashboard</a>
      <div class="nav-section">GESTIÓN</div>
      <a href="index.php?controller=admin&action=citas" class="<?= ($ctrl==='admin'&&$action==='citas')?'active':'' ?>" onclick="gsClose()">&#128197; Citas</a>
      <a href="index.php?controller=admin&action=clientes" class="<?= ($ctrl==='admin'&&$action==='clientes')?'active':'' ?>" onclick="gsClose()">&#128101; Clientes</a>
      <a href="index.php?controller=admin&action=servicios" class="<?= ($ctrl==='admin'&&$action==='servicios')?'active':'' ?>" onclick="gsClose()">&#10024; Servicios</a>
      <?php if ($isAdmin): ?>
      <a href="index.php?controller=admin&action=empleados" class="<?= ($ctrl==='admin'&&$action==='empleados')?'active':'' ?>" onclick="gsClose()">&#128188; Empleadas</a>
      <?php endif; ?>
      <div class="nav-section">EMPLEADA</div>
      <a href="index.php?controller=empleado&action=index" class="<?= ($ctrl==='empleado'&&$action==='index')?'active':'' ?>" onclick="gsClose()">&#128193; Citas del día</a>
      <a href="index.php?controller=empleado&action=perfil" class="<?= ($ctrl==='empleado'&&$action==='perfil')?'active':'' ?>" onclick="gsClose()">&#128100; Mi Perfil</a>
    <?php else: ?>
      <div class="nav-section">MI CUENTA</div>
      <a href="index.php?controller=cliente&action=index" class="<?= ($ctrl==='cliente'&&$action==='index')?'active':'' ?>" onclick="gsClose()">&#128203; Mis Citas</a>
      <a href="index.php?controller=cliente&action=catalogo" class="<?= ($ctrl==='cliente'&&$action==='catalogo')?'active':'' ?>" onclick="gsClose()">&#10024; Catálogo</a>
      <a href="index.php?controller=cliente&action=agendar" class="<?= ($ctrl==='cliente'&&$action==='agendar')?'active':'' ?>" onclick="gsClose()">&#128197; Agendar</a>
      <a href="index.php?controller=cliente&action=perfil" class="<?= ($ctrl==='cliente'&&$action==='perfil')?'active':'' ?>" onclick="gsClose()">&#128100; Mi Perfil</a>
    <?php endif; ?>
    <div class="nav-section">SESIÓN</div>
    <a href="index.php?controller=auth&action=logout">&#128682; Cerrar sesión</a>
  </nav>
  <div class="sidebar-footer">
    <div style="font-weight:600"><?= htmlspecialchars($usuario['nombre'] ?? '') ?></div>
    <div style="font-size:.75em;color:#95a5a6"><?= ucfirst($usuario['rol'] ?? '') ?></div>
  </div>
</aside>

<script>
(function(){
  var sb  = document.getElementById('gs-sidebar');
  var ov  = document.getElementById('gs-overlay');
  var hb  = document.getElementById('gs-hamburger');
  window.gsToggleSidebar = function(){
    sb.classList.toggle('open');
    ov.classList.toggle('open');
    hb.classList.toggle('is-open');
    document.body.style.overflow = sb.classList.contains('open') ? 'hidden' : '';
  };
  window.gsClose = function(){
    if(window.innerWidth <= 768){
      sb.classList.remove('open');
      ov.classList.remove('open');
      hb.classList.remove('is-open');
      document.body.style.overflow = '';
    }
  };
  document.addEventListener('keydown', function(e){ if(e.key==='Escape') window.gsClose(); });
})();
</script>
