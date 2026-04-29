<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Catálogo – Glamour Stock</title>
<link rel="stylesheet" href="public/css/main.css">
</head>
<body>
<?php require_once __DIR__ . '/../_menu.php'; ?>
<div class="main">
  <div class="topbar">
    <div class="topbar-title">✨ Nuestros Servicios</div>
    <div class="topbar-right">
      <a href="index.php?controller=cliente&action=agendar" class="btn-primary">📅 Agendar</a>
      <div class="avatar"><?= strtoupper(substr($usuario['nombre'],0,2)) ?></div>
    </div>
  </div>
  <div class="content">
    <?php
    $categorias = array_unique(array_column($servicios, 'categoria'));
    sort($categorias);
    ?>
    <?php foreach($categorias as $cat): ?>
    <div style="margin-bottom:8px;font-size:.78em;font-weight:700;text-transform:uppercase;color:var(--primary);letter-spacing:1px"><?= htmlspecialchars($cat) ?></div>
    <div class="cards-grid" style="padding:0 0 24px">
      <?php foreach($servicios as $s): if($s['categoria']!==$cat) continue; ?>
      <div class="serv-card">
        <div class="serv-cat"><?= htmlspecialchars($s['categoria']) ?></div>
        <div class="serv-nombre"><?= htmlspecialchars($s['nombre']) ?></div>
        <div class="serv-desc"><?= htmlspecialchars($s['descripcion']??'') ?></div>
        <div class="serv-meta">
          <span class="serv-precio">$<?= number_format($s['precio'],0,',','.') ?></span>
          <span class="serv-dur">⏱ <?= $s['duracion'] ?> min</span>
        </div>
        <a href="index.php?controller=cliente&action=agendar&servicio_id=<?= $s['id'] ?>"
           style="display:block;margin-top:14px;text-align:center;background:var(--primary);color:white;padding:8px;border-radius:7px;text-decoration:none;font-size:.84em;font-weight:700">
          Agendar este servicio →
        </a>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
  </div>
</div>
</body>
</html>
