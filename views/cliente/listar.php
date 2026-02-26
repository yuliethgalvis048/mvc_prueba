
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="index.php?controller=cliente&action=crear">crear</a>
    <a href="index.php?controller=login&action=logout">cerrar</a>
    <?=$_SESSION['user']?>
    <table>
        <thead>
          <th>NOMBRE</th>
          <th>APELLIDO</th>
          <th>EDAD</th>
          <th>CONTRASEÑA</th>
          <th>CORREO</th>
          <th>DIRECCION</th>
          <th>TELEFONO</th>
        </thead>
        <tbody>
            <?php foreach($datos as $u): ?>
            <tr>
              <td><?=$u['nombre']?></td>
              <td><?=$u['apellido']?></td>
              <td><?=$u['edad']?></td>
              <td><?=$u['pass']?></td>
              <td><?=$u['correo_electronico']?></td>
              <td><?=$u['direccion']?></td>
              <td><?=$u['telefono']?></td>
              <td> 
                <a href="index.php?controller=cliente&action=editar&id=<?=$u['id_cliente']?>">editar</a>
                
                <a href="index.php?controller=cliente&action=eliminar&id=<?=$u['id_cliente']?>">eliminar</a>
              </td>
            </tr>
            
             <?php endforeach ?>
            
        </tbody>
    </table>

</body>
</html>





