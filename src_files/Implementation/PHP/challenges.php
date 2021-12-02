<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="challenges.css">
</head>
<body>
    <h1>Challenges</h1>
    
<?php 
    $host = "localhost";
       $user = "WEBUSERCREDS"; //REMEMBER TO CHANGE THIS TO WEBUSER CREDENTIALS
       $pass = "PASSWORD";
       $dbse = "pokemon_league";

       if (!$conn = new mysqli($host, $user, $pass, $dbse)){
           echo "Error: Failed to make a MySQL connection: " . "<br>";
           echo "Errno: $conn->connect_errno; i.e. $conn->connect_error \n"; exit;
           }

    
    $getChallenges = "SELECT * FROM challenges;";
    //$bigdelete = "DELETE FROM items;";
    $result = $conn->query($getChallenges);

// Prepare the delete statement
//$stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?;");
//$stmt->bind_param('i', $id);
//$stmt2 = $conn->prepare($bigdelete);




$all_results = $result->fetch_all();
$all_results_rows = $result->num_rows;

if(isset($_POST["insertChallenge"])) {
    $insertstmt = $conn->prepare("INSERT INTO challenges (challenge_date,challenge_progress_made,trainer_id) VALUES (?,?,?);");
    $insertstmt->bind_param('sii', $date,$progress,$trainer);
    $date = htmlspecialchars($_POST["challengeDate"]);
    $progress = htmlspecialchars($_POST["challengeProgressMade"]);
    $trainer = htmlspecialchars($_POST["trainerID"]);
    $insertstmt->execute();
    header("Refresh:0");
}

if(isset($_POST["deleteChallenge"])) {
    $updatestmt = $conn->prepare("DELETE FROM challenges WHERE challenge_id = ?;");
    $updatestmt->bind_param('i',$challengeid);
    $pokemonid = htmlspecialchars($_POST["challengeDeleteID"]);
    $updatestmt->execute();
    header("Refresh:0");
}






$new_result = $conn->query($getChallenges);


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
<form action="challenges.php" method=POST>
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

<form action="challenges.php" method=POST>
<p>Add a new Challenge here</p>
<input type="text" name="challengeDate" placeholder="ChallengeDate" method=POST/>
<input type="text" name="challengeProgressMade" placeholder="ChallengeProgress" method=POST/>
<input type="text" name="trainerID" placeholder="TrainerID" method=POST/>
<input type="submit" name="insertChallenge" value="Add New Challenge" method=POST/>
</form>

<form action="challenges.php" method=POST>
<p>Delete Challenge</p>
<input type="text" name="challengeDeleteID" placeholder="ChallengeID" method=POST/>
<input type="submit" name="deleteChallenge" value="Delete Challenge" method=POST/>
</form>

<a href="/GroupPHP/index.php">Go back</a>


<?php
}


?>
