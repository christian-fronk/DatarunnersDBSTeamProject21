<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="species.css">
</head>
<body>
    <h1>Pokemon Species Type</h1>
    
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
    
    $getType = "SELECT * FROM pokemon_species_types;";
    //$bigdelete = "DELETE FROM items;";
    $result = $conn->query($getType);

// Prepare the delete statement
//$stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?;");
//$stmt->bind_param('i', $id);
//$stmt2 = $conn->prepare($bigdelete);





$all_results = $result->fetch_all();
$all_results_rows = $result->num_rows;

if(isset($_POST["insertType"])) {
    $insertstmt = $conn->prepare("INSERT INTO pokemon_species_types (species_name, pokemon_type_name) VALUES (?,?);");
    $insertstmt->bind_param('ss', $i_name,$i_type);
    $i_name = htmlspecialchars($_POST["Iname"]);
    $i_type = htmlspecialchars($_POST["Itype"]);
    $insertstmt->execute();
    header("Refresh:0");
}

if(isset($_POST["deleteType"])) {
    $updatestmt = $conn->prepare("DELETE FROM pokemon_species_types WHERE species_name = ? AND pokemon_type_name = ?;");
    $updatestmt->bind_param('ss',$d_name, $d_type);
    $d_name = htmlspecialchars($_POST["Dname"]);
    $d_type = htmlspecialchars($_POST["Dtype"]);
    $updatestmt->execute();
    header("Refresh:0");
}


$new_result = $conn->query($getType);


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
<form action="pokemonSpeciesTypes" method=POST>
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

<form action="pokemonSpeciesTypes" method=POST>
<p>Add a new pokemon species type</p>
<input type="text" name="Iname" placeholder="Pokemon species name" method=POST/>
<input type="text" name="Itype" placeholder="Pokemon species type" method=POST/>
<input type="submit" name="insertType" value="Insert pokemon species type" method=POST/>
</form>



<form action="pokemonSpeciesTypes" method=POST>
<p>Delete a pokemon species type</p>
<input type="text" name="Dname" placeholder="Pokemon species name" method=POST/>
<input type="text" name="Dtype" placeholder="Pokemon species type" method=POST/>
<input type="submit" name="deleteType" value="Delete Pokemon Species Type" method=POST/>
</form>

<a href="/GroupPHP/index.php">Go back</a>

<?php
}
?>
