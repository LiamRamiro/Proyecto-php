
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <title>Menu pokemon</title>
    <link rel="stylesheet" href="pokedex.css">
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
   
    <form action='pokedex.php'>
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

function countPokemons($connection) {
    $sql = "SELECT COUNT(*) AS total FROM pokemon";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}


$memoria = $_GET['buscador'];

$sqlmain = 'select p.numero_pokedex , p.nombre , eb.ps , eb.ataque , eb.defensa , eb.especial , eb.velocidad 
from pokemon p, estadisticas_base eb 
where p.numero_pokedex = eb.numero_pokedex';

$sql_name = " and p.nombre like '$memoria%'";


if ($memoria == "") {
    $sql = $sqlmain;
} else {
    $sql = $sqlmain . $sql_name;
}


$result = mysqli_query($mysqli, $sql);
if (!$result) {
    die("Invalid query:" . mysql_error());
} else {
    //iterate all rows
    echo "<table border = 1>";
    echo "<tr><th>ID</th><th>Nombre</th><th>PS</th><th>ATAQUE</th><th>DEFENSA</th><th>ESPECIAL</th><th>VELOCIDAD</th></tr>";

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
        echo "<td>" . $row['ps'] . "</td>";
        echo "<td>" . $row['ataque'] . "</td>";
        echo "<td>" . $row['defensa'] . "</td>";
        echo "<td>" . $row['especial'] . "</td>";
        echo "<td>" . $row['velocidad'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";

    $pokemonCount = countPokemons($mysqli);
    echo "<p>Total Pokémon: $pokemonCount</p>";
}

mysqli_close($mysqli);
?>
</div>
</body>
</html>