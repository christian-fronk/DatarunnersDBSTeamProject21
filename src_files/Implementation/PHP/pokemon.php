<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="basic.css">
</head>
<body>
    <h1>Pokemon</h1>
    
<?php 
    $host = "localhost";
       $user = "WEBUSERCREDS"; //REMEMBER TO CHANGE THIS TO WEBUSER CREDENTIALS
       $pass = "WEBUSERPASS";
       $dbse = "pokemon_league";

       if (!$conn = new mysqli($host, $user, $pass, $dbse)){
           echo "Error: Failed to make a MySQL connection: " . "<br>";
           echo "Errno: $conn->connect_errno; i.e. $conn->connect_error \n"; exit;
           }

    
    $getPokemon = "SELECT * FROM pokemon;";
    //$bigdelete = "DELETE FROM items;";
    $result = $conn->query($getPokemon);

// Prepare the delete statement
//$stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?;");
//$stmt->bind_param('i', $id);
//$stmt2 = $conn->prepare($bigdelete);




$all_results = $result->fetch_all();
$all_results_rows = $result->num_rows;

if(isset($_POST["insertPokemon"])) {
    $insertstmt = $conn->prepare("INSERT INTO pokemon (pokemon_level,trainer_id,species_name) VALUES (?,?,?);");
    $insertstmt->bind_param('iis', $level,$trainer,$species);
    $level = $_POST["pokemonLevel"];
    $trainer = $_POST["trainerID"];
    $species = $_POST["speciesName"];
    $insertstmt->execute();
    header("Refresh:0");
}

if(isset($_POST["updatePokemonLevel"])) {
    $updatestmt = $conn->prepare("UPDATE pokemon SET pokemon_level = ? WHERE pokemon_id = ?;");
    $updatestmt->bind_param('ii', $level,$pokemonid);
    $level = $_POST["pokemonLevelUpdate"];
    $pokemonid = $_POST["pokemonIDLevel"];
    $updatestmt->execute();
    header("Refresh:0");
}

if(isset($_POST["deletePokemon"])) {
    $updatestmt = $conn->prepare("DELETE FROM pokemon WHERE pokemon_id = ?;");
    $updatestmt->bind_param('i',$pokemonid);
    $pokemonid = $_POST["pokemonDeleteID"];
    $updatestmt->execute();
    header("Refresh:0");
}






$new_result = $conn->query($getPokemon);


result_to_table($new_result);

    $conn->close();
?>

</body>
</html>
<?php

function result_to_table($res) {
    $nrows = $res->num_rows;
    $ncols = $res->field_count;
    $resar = $res->fetch_all();

    ?> 
    <p>
   This table has <?php echo $ncols; ?> columns, and <?php echo $nrows; ?> rows.
    </p>
<form action="pokemon.php" method=POST>
        <table>
        <thead>
        <tr>
    <?php
    while ($fld = $res->fetch_field()) {
    ?>
        <th><?php echo $fld->name; ?></th>
    <?php
    }
    ?>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0;$i<$nrows; $i++) {
    ?>
    <tr>
    <?php
        for ( $j = 0; $j < $ncols; $j++ ) {
    ?>
            <td><?php echo $resar[$i][$j]; ?></td>
    <?php
        }
    ?>        
        </tr>
    <?php
    }
?>
    </tbody>
    </table>
</form>

<form action="pokemon.php" method=POST>
<p>Add a new Pokemon here</p>
<input type="text" name="pokemonLevel" placeholder="PokemonLevel" method=POST/>
<input type="text" name="trainerID" placeholder="TrainerID" method=POST/>
<input type="text" name="speciesName" placeholder="SpeciesName" method=POST/>
<input type="submit" name="insertPokemon" value="Add New Pokemon" method=POST/>
</form>


<form action="pokemon.php" method=POST>
<p>Update Pokemon Level </p>
<input type="text" name="pokemonIDLevel" placeholder="PokemonID" method=POST/>
<input type="text" name="pokemonLevelUpdate" placeholder="PokemonLevel" method=POST/>
<input type="submit" name="updatePokemonLevel" value="Update Pokemon Level" method=POST/>
</form>


<form action="pokemon.php" method=POST>
<p>Update Pokemon's Trainer </p>
<input type="text" name="pokemonIDTrainer" placeholder="PokemonID" method=POST/>
<input type="text" name="pokemonTrainerUpdate" placeholder="TrainerID" method=POST/>
<input type="submit" name="updatePokemonTrainer" value="Update Pokemon's Trainer" method=POST/>
</form>


<form action="pokemon.php" method=POST>
<p>Delete Pokemon</p>
<input type="text" name="pokemonDeleteID" placeholder="PokemonID" method=POST/>
<input type="submit" name="deletePokemon" value="Delete Pokemon" method=POST/>
</form>


<?php
}


?>
