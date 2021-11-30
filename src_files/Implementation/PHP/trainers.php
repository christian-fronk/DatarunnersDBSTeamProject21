<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="basic.css">
</head>
<body>
    <h1>Trainers</h1>
    
<?php 

    $host = "localhost";
       $user = "WEBUSERCREDS"; //REMEMBER TO CHANGE THIS TO WEBUSER CREDENTIALS
       $pass = "PASSWORD";
       $dbse = "pokemon_league";

       if (!$conn = new mysqli($host, $user, $pass, $dbse)){
           echo "Error: Failed to make a MySQL connection: " . "<br>";
           echo "Errno: $conn->connect_errno; i.e. $conn->connect_error \n"; exit;
           }
    
    $gettrainers = "SELECT * FROM trainers;";
    //$bigdelete = "DELETE FROM trainers;";
    $result = $conn->query($gettrainers);

// Prepare the delete statement
//$stmt = $conn->prepare("DELETE FROM trainers WHERE trainer_id = ?;");
//$stmt->bind_param('i', $id);
//$stmt2 = $conn->prepare($bigdelete);




$all_results = $result->fetch_all();
$all_results_rows = $result->num_rows;

if(isset($_POST["insertTrainer"])) {
    $insertstmt = $conn->prepare("INSERT INTO trainers (trainer_name,trainer_hometown,trainer_dob,isActive) VALUES (?,?,?,'1');");
    $insertstmt->bind_param('sss', $name,$hometown,$dob);
    $name = htmlspecialchars($_POST["trainerName"]);
    $hometown = htmlspecialchars($_POST["trainerHometown"]);
    $dob = htmlspecialchars($_POST["trainerDOB"]);
    $insertstmt->execute();
    header("Refresh:0");
}

if(isset($_POST["updateTrainerName"])) {
    $updatestmt = $conn->prepare("UPDATE trainers SET trainer_name = ? WHERE trainer_id = ?;");
    $updatestmt->bind_param('si', $name,$trainerid);
    $name = htmlspecialchars($_POST["trainerNameUpdate"]);
    $trainerid = htmlspecialchars($_POST["trainerNameID"]);
    $updatestmt->execute();
    header("Refresh:0");
}

if(isset($_POST["updateTrainerHometown"])) {
    $updatestmt = $conn->prepare("UPDATE trainers SET trainer_hometown = ? WHERE trainer_id = ?;");
    $updatestmt->bind_param('si', $hometown,$trainerid);
    $hometown = htmlspecialchars($_POST["trainerHometownUpdate"]);
    $trainerid = htmlspecialchars($_POST["trainerHometownID"]);
    $updatestmt->execute();
    header("Refresh:0");
}

if(isset($_POST["updateTrainerAge"])) {
    $updatestmt = $conn->prepare("UPDATE trainers SET trainer_age = ? WHERE trainer_id = ?;");
    $updatestmt->bind_param('ii', $age,$trainerid);
    $age = htmlspecialchars($_POST["trainerAgeUpdate"]);
    $trainerid = htmlspecialchars($_POST["trainerAgeID"]);
    $updatestmt->execute();
    header("Refresh:0");
}

    if(isset($_POST["updateTrainerActive"])) {
        $updatestmt = $conn->prepare("UPDATE trainers SET isActive = ? WHERE trainer_id = ?;");
        $updatestmt->bind_param('ii', $active,$trainerid);
        $active = htmlspecialchars($_POST["activePick"]);
        $trainerid = htmlspecialchars($_POST["trainerActiveID"]);
        echo "<p>".$active."</p>";
        $updatestmt->execute();
        header("Refresh:0");
    }


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



$new_result = $conn->query($gettrainers);


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
<form action="trainers.php" method=POST>
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

<form action="trainers.php" method=POST>
<p>Add a new Trainer here</p>
<input type="text" name="trainerName" placeholder="Name" method=POST/>
<input type="text" name="trainerHometown" placeholder="Hometown" method=POST/>
<input type="text" name="trainerDOB" placeholder="DOB (YYYY-MM-DD)" method=POST/>
<input type="submit" name="insertTrainer" value="Add New Trainer" method=POST/>
</form>

<form action="trainers.php" method=POST>
<p>Update Trainer Name </p>
<input type="text" name="trainerNameID" placeholder="TrainerID" method=POST/>
<input type="text" name="trainerNameUpdate" placeholder="Name" method=POST/>
<input type="submit" name="updateTrainerName" value="Update Trainer Name" method=POST/>
</form>

<form action="trainers.php" method=POST>
<p>Update Trainer Hometown </p>
<input type="text" name="trainerHometownID" placeholder="TrainerID" method=POST/>
<input type="text" name="trainerHometownUpdate" placeholder="Hometown" method=POST/>
<input type="submit" name="updateTrainerHometown" value="Update Trainer Hometown" method=POST/>
</form>

<form action="trainers.php" method=POST>
<p>Update Trainer Active </p>
<input type="text" name="trainerActiveID" placeholder="TrainerID" method=POST/>
  <label for="activePick">Choose status:</label>
  <select id="activePick" name="activePick">
    <option value="1">Active</option>
    <option value="0">Inactive</option>
  </select>
  <input type="submit" name="updateTrainerActive" value="Update Trainer Active" method=POST/>
</form>


<?php
}


?>
