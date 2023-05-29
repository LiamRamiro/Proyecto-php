
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <title>Menu pokemon</title>
    <link rel="stylesheet" href="movimientos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    
</head>
<body>

   <nav>

        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <a href="#" class="enlace">
            <img src="imagenes/pokeball.jpg" alt="pokeball" class="logo">
        </a>
        <ul>
            <li><a class="active" href="/index.html">Inicio</a></li>
            <li><a href="/pokedex.php">Pokedex</a></li>
            <li><a href="/insertarPokemon.php">Insertar pokemon</a></li>
            <li><a href="/movimientos.php">Movimientos</a></li>
        </ul>

   </nav>
   
    <form action='movimientos.php'>
    <select id="tipo" name=tipo  >
        <option selected disabled>TIPO</option>
        <option value="Agua">Agua</option>
        <option value="Bicho">Bicho</option>
        <option value="Dragon">Dragon</option>
        <option value="Electrico">Electrico</option>
        <option value="Fantasma">Fantasma</option>
        <option value="Fuego">Fuego</option>
        <option value="Hada">Hada</option>
        <option value="Hielo">Hielo</option>
        <option value="Lucha">Lucha</option>
        <option value="Normal">Normal</option>
        <option value="Planta">Planta</option>
        <option value="Psiquico">Psiquico</option>
        <option value="Roca">Roca</option>
        <option value="Tierra">Tierra</option>
        <option value="Veneno">Veneno</option>
        <option value="Volador">Volador</option>
    </select>
    <input type="text" id="buscador" name='buscador'>
    <button type="submit" value="Buscar" id="buscar">
        Buscar 
    </button>



    </form>
    

    
<div id="tabla">
<?php

$mysqli = mysqli_connect("172.17.0.2", "root", "liam", "pokemondb");
if (!$mysqli) {
    echo "<p>Error: No se pudo conectar a MySQL." . PHP_EQL;
    echo "<p>error de depuracion: " . mysqli_connect_error() . PHP_EOL;
    exit;
}


$memoria = $_GET['buscador'];

$nombre = $_GET['tipo'];

$sqlmain = 'select DISTINCT m.id_movimiento, m.nombre_m , t.nombreTipo , m.potencia , m.precision_mov , m.pp 
from pokemon p, pokemon_tipo pt, tipo t , movimiento m
where p.numero_pokedex = pt.numero_pokedex
and pt.id_tipo = t.id_tipo
and t.id_tipo = m.id_tipo ';

$sqlname = 'and p.nombre = "' . $memoria . '"';

$sqlorder = ' order by m.id_movimiento';

$sql_type = 'and t.nombreTipo = "'.$nombre.'" ';

if($nombre == "")
          $sql1 = $sql_default.$sql_order;
        else{
          $sql1 = $sqlmain.$sql_type;
        }

if ($memoria == "") {
    $sql = $sqlmain.$sqlorder;
}else{
    $sql = $sqlmain.$sqlname.$sqlorder;}

if ($nombre != "" && $memoria == "") {
    $sql = $sqlmain.$sql_type;
}


$sql = $sqlmain;



$result = mysqli_query($mysqli, $sql);
if (!$result) {
    die("Invalid query:" . mysql_error().$sql);
} else {
    //iterate all rows
    echo "<table border = 1>";
    echo "<tr><th>ID</th><th>NOMBRE</th><th>TIPO</th><th>POTENCIA</th><th>PRECISION</th><th>PP</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        
        echo "<tr>";
        echo "<td>" . $row['id_movimiento'] . "</td>";
        echo "<td>" . $row['nombre_m'] . "</td>";
        echo "<td>" . $row['nombreTipo'] . "</td>";
        echo "<td>" . $row['potencia'] . "</td>";
        echo "<td>" . $row['precision_mov'] . "</td>";
        echo "<td>" . $row['pp'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}

mysqli_close($mysqli);
?>
</div>
</body>
</html>