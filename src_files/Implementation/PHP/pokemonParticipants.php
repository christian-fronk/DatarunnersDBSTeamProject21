<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="pokeparticipants.css">
</head>
<body>
    <h1>Pokemon Participants</h1>
    
<?php 
    $host = "localhost";
    $user = "WEBUSERCREDS"; //REMEMBER TO CHANGE THIS TO WEBUSER CREDENTIALS
    $pass = "PASSWORD";
    $dbse = "pokemon_league";

    if (!$conn = new mysqli($host, $user, $pass, $dbse)){
        echo "Error: Failed to make a MySQL connection: " . "<br>";
        echo "Errno: $conn->connect_errno; i.e. $conn->connect_error \n"; exit;
        }
        
    $getParticipants = "SELECT * FROM pokemon_participants;";
    //$bigdelete = "DELETE FROM items;";
    $result = $conn->query($getParticipants);

// Prepare the delete statement
//$stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?;");
//$stmt->bind_param('i', $id);
//$stmt2 = $conn->prepare($bigdelete);




$all_results = $result->fetch_all();
$all_results_rows = $result->num_rows;

if(isset($_POST["insertParticipant"])) {
    $insertstmt = $conn->prepare("INSERT INTO pokemon_participants (pokemon_id, challenge_id) VALUES (?,?);");
    $insertstmt->bind_param('ii', $pokemon,$challenge);
    $pokemon = htmlspecialchars($_POST["pokemonInsertID"]);
    $challenge = htmlspecialchars($_POST["challengeInsertID"]);
    $insertstmt->execute();
    header("Refresh:0");
}

if(isset($_POST["deleteParticipant"])) {
    $updatestmt = $conn->prepare("DELETE FROM pokemon_participants WHERE (pokemon_id = ? AND challenge_id = ?);");
    $updatestmt->bind_param('ii',$pokemon,$challenge);
    $pokemon = htmlspecialchars($_POST["pokemonDeleteID"]);
    $challenge = htmlspecialchars($_POST["challengeDeleteID"]);
    $updatestmt->execute();
    header("Refresh:0");
}


$new_result = $conn->query($getParticipants);


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
<form action="pokemonParticipants.php" method=POST>
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

<form action="pokemonParticipants.php" method=POST>
<p>Add a new participant</p>
<input type="text" name="pokemonInsertID" placeholder="PokemonID" method=POST/>
<input type="text" name="challengeInsertID" placeholder="ChallengeID" method=POST/>
<input type="submit" name="insertParticipant" value="Add New Participant" method=POST/>
</form>

<form action="pokemonParticipants.php" method=POST>
<p>Delete participant</p>
<input type="text" name="pokemonDeleteID" placeholder="PokemonID" method=POST/>
<input type="text" name="challengeDeleteID" placeholder="ChallengeID" method=POST/>
<input type="submit" name="deleteParticipant" value="Delete Participant" method=POST/>
</form>

<a href="/GroupPHP/index.php">Go back</a>

<?php
}
?>
