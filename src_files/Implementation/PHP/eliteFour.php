<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="basic.css">
</head>
<body>
    <h1>Elite Four</h1>
    
<?php 
     $host = "localhost";
     $user = "christiansmac"; //REMEMBER TO CHANGE THIS TO WEBUSER CREDENTIALS
     $pass = "dweedwee";
     $dbse = "pokemon_league";

     if (!$conn = new mysqli($host, $user, $pass, $dbse)){
         echo "Error: Failed to make a MySQL connection: " . "<br>";
         echo "Errno: $conn->connect_errno; i.e. $conn->connect_error \n"; exit;
         }
    
    $getElite = "SELECT * FROM elite_four;";
    //$bigdelete = "DELETE FROM items;";
    $result = $conn->query($getElite);

// Prepare the delete statement
//$stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?;");
//$stmt->bind_param('i', $id);
//$stmt2 = $conn->prepare($bigdelete);





$all_results = $result->fetch_all();
$all_results_rows = $result->num_rows;

if(isset($_POST["insertEliteFour"])) {
    $insertstmt = $conn->prepare("INSERT INTO elite_four (elite_four_position, type_specialty) VALUES (?,?);");
    $insertstmt->bind_param('is', $pos,$spec);
    $pos = $_POST["Epos"];
    $spec = $_POST["Espec"];
    $insertstmt->execute();
    header("Refresh:0");
}

if(isset($_POST["deleteEliteFour"])) {
    $updatestmt = $conn->prepare("DELETE FROM elite_four WHERE trainer_id = ?;");
    $updatestmt->bind_param('i',$sold);
    $sold = $_POST["EliteDeleteID"];
    $updatestmt->execute();
    header("Refresh:0");
}


$new_result = $conn->query($getElite);


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
<form action="eliteFour.php" method=POST>
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

<form action="eliteFour.php" method=POST>
<p>Add a new elite four member</p>
<input type="text" name="Epos" placeholder="Elite4Position" method=POST/>
<input type="text" name="Espec" placeholder="Elite4Specialty" method=POST/>
<input type="submit" name="insertEliteFour" value="Add Elite Four Member" method=POST/>
</form>



<form action="eliteFour.php" method=POST>
<p>Delete elite four member</p>
<input type="text" name="EliteDeleteID" placeholder="Trainer ID" method=POST/>
<input type="submit" name="deleteEliteFour" value="Delete Sold Item" method=POST/>
</form>


<?php
}
?>