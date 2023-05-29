
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <title>Menu pokemon</title>
    <link rel="stylesheet" href="insertarPokemon.css">
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

    <form action='insertarPokemon.php'>
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

$sqlmain = 'select distinct p.numero_pokedex , p.nombre , t.nombreTipo, eb.ps , p.altura , p.peso 
from pokemon p, estadisticas_base eb, pokemon_tipo pt, tipo t 
where p.numero_pokedex = eb.numero_pokedex
and p.numero_pokedex = pt.numero_pokedex
and pt.id_tipo = t.id_tipo';

$sql_name = " and p.nombre like '$memoria%'";

$sqlorder = ' order by p.numero_pokedex asc';

if ($memoria == "") {
    $sql = $sqlmain.$sqlorder;
}else{
    $sql = $sqlmain.$sqlname.$sqlorder;}

$sql = $sqlmain;
    
$result = mysqli_query($mysqli, $sql);
if (!$result) {
    die("Invalid query:" . mysql_error());
} else {
    //iterate all rows
    echo "<table border = 1>";
    echo "<tr><th>ID</th><th>Nombre</th><th>TIPO</th><th>PS</th><th>ALTURA</th><th>PESO</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        
        echo "<tr>";
        echo "<td>" . $row['numero_pokedex'] . "</td>";
        echo "<tr>";
          if ($row['numero_pokedex'] < 10) {
            echo "<td> <img src='https://assets.pokemon.com/assets/cms2/img/pokedex/detail/"."00"."$row[numero_pokedex].png'  alt='' id='imgpok'> </td>";
          } else if ($row['numero_pokedex'] < 100) {
            echo "<td> <img src='https://assets.pokemon.com/assets/cms2/img/pokedex/detail/"."0"."$row[numero_pokedex].png'height=150 alt='' id='imgpok'> </td>";
          } else {
            echo "<td> <img src='https://assets.pokemon.com/assets/cms2/img/pokedex/detail/$row[numero_pokedex].png' height=150 alt='' id='imgpok'> </td>";
          }

        echo "<td>" . $row['nombre'] . "</td>";
        echo "<td>" . $row['nombreTipo'] . "</td>";
        echo "<td>" . $row['ps'] . "</td>";
        echo "<td>" . $row['altura'] . "</td>";
        echo "<td>" . $row['peso'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}

mysqli_close($mysqli);
?>
</div>
</body>
</html>