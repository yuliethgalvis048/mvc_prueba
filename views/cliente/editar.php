<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="" method="post">
    <input type="text" name="id" placeholder="" value="<?=$datos['id_cliente']?>">
    <input type="text" name="nombre" placeholder="nombre" value="<?=$datos['nombre']?>">
    <input type="text" name="apellido" placeholder="apellido" value="<?=$datos['apellido']?>">
    <input type="number" name="edad" placeholder="edad" value="<?=$datos['edad']?>">
    <input type="text" name="pass" placeholder="contraseña" value="<?=$datos['pass']?>">
    <input type="email" name="correo" placeholder="correo" value="<?=$datos['correo_electronico']?>">
    <input type="text" name="direccion" placeholder="direccion" value="<?=$datos['direccion']?>"> 
    <input type="number" name=telefono placeholder="telefono" value="<?=$datos['telefono']?>">
    <input type="submit" value="Editar">
    </form>
</body>
</html>   