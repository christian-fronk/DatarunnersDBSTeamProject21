<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="pokemontypes.css">
</head>
<body>
    <h1>Pokemon Species</h1>
    
<?php 
    //Note-This is the version WITHOUT trainer DOB edit
    $host = "localhost";
    $user = "WEBUSERCREDS"; //REMEMBER TO CHANGE THIS TO WEBUSER CREDENTIALS
    $pass = "PASSWORD";
    $dbse = "pokemon_league";

    if (!$conn = new mysqli($host, $user, $pass, $dbse)){
        echo "Error: Failed to make a MySQL connection: " . "<br>";
        echo "Errno: $conn->connect_errno; i.e. $conn->connect_error \n"; exit;
        }

    
    $getSpecies = "SELECT * FROM pokemon_species;";
    //$bigdelete = "DELETE FROM trainers;";
    $result = $conn->query($getSpecies);

// Prepare the delete statement
//$stmt = $conn->prepare("DELETE FROM trainers WHERE trainer_id = ?;");
//$stmt->bind_param('i', $id);
//$stmt2 = $conn->prepare($bigdelete);




$all_results = $result->fetch_all();
$all_results_rows = $result->num_rows;

if(isset($_POST["insertSpecies"])) {
    $insertstmt = $conn->prepare("INSERT INTO pokemon_species (species_name) VALUES (?);");
    $insertstmt->bind_param('s',$name);
    $name = htmlspecialchars($_POST["speciesName"]);
    $insertstmt->execute();
    header("Refresh:0");
}

if(isset($_POST["deleteSpecies"])) {
    $updatestmt = $conn->prepare("DELETE FROM pokemon_species WHERE species_name = ?;");
    $updatestmt->bind_param('s',$name);
    $name = htmlspecialchars($_POST["speciesNameDelete"]);
    $updatestmt->execute();
    header("Refresh:0");
}




//if(isset($_POST["updateTrainerActive"])) {
//    $updatestmt = $conn->prepare("UPDATE trainers SET isActive = ? WHERE trainer_id = ?;");
//    $updatestmt->bind_param('ii', $active,$trainerid);
//    $active = $_POST["trainerActiveUpdate"];
//    $trainerid = $_POST["trainerActiveID"];
//    $updatestmt->execute();
//    header("Refresh:0");
//}





//if(isset($_POST["deleteallcheck"])) {
//	$stmt2->execute();
//}


//for($i = 0; $i < $all_results_rows; $i++) {
//	$id = $all_results[$i][0];
//    if(isset($_POST["checkbox" . $id]) && !$stmt->execute()) {
        // Bind and execute the prepared statement
//        echo $conn->error;
//    }
//}



$new_result = $conn->query($getSpecies);


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
<form action="pokemonSpecies.php" method=POST>
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

<form action="pokemonSpecies.php" method=POST>
<p>Add a new Pokemon species</p>
<input type="text" name="speciesName" placeholder="SpeciesName" method=POST/>
<input type="submit" name="insertSpecies" value="Add New Species" method=POST/>
</form>

<form action="pokemonSpecies.php" method=POST>
<p>Delete Pokemon species</p>
<input type="text" name="speciesNameDelete" placeholder="SpeciesName" method=POST/>
<input type="submit" name="deleteSpecies" value="Delete Species" method=POST/>
</form>


<?php
}


?>
