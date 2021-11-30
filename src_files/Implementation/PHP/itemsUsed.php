<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="basic.css">
</head>
<body>
    <h1>Items Used</h1>
    
<?php 
    $host = "localhost";
    $user = "WEBUSERCREDS"; //REMEMBER TO CHANGE THIS TO WEBUSER CREDENTIALS
    $pass = "PASSWORD";
    $dbse = "pokemon_league";

    if (!$conn = new mysqli($host, $user, $pass, $dbse)){
        echo "Error: Failed to make a MySQL connection: " . "<br>";
        echo "Errno: $conn->connect_errno; i.e. $conn->connect_error \n"; exit;
        }
        
    $getItemsUsed = "SELECT * FROM items_used;";
    //$bigdelete = "DELETE FROM items;";
    $result = $conn->query($getItemsUsed);

// Prepare the delete statement
//$stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?;");
//$stmt->bind_param('i', $id);
//$stmt2 = $conn->prepare($bigdelete);




$all_results = $result->fetch_all();
$all_results_rows = $result->num_rows;

if(isset($_POST["insertItemUsed"])) {
    $insertstmt = $conn->prepare("INSERT INTO items_used (item_sold_id, challenge_id) VALUES (?,?);");
    $insertstmt->bind_param('ii', $item_sold,$challenge);
    $item_sold = htmlspecialchars($_POST["soldItemInsertID"]);
    $challenge = htmlspecialchars($_POST["challengeInsertID"]);
    $insertstmt->execute();
    header("Refresh:0");
}

if(isset($_POST["deleteItemUsed"])) {
    $updatestmt = $conn->prepare("DELETE FROM items_used WHERE (item_sold_id = ? AND challenge_id = ?);");
    $updatestmt->bind_param('ii',$item_sold,$challenge);
    $item_sold = htmlspecialchars($_POST["soldItemDeleteID"]);
    $challenge = htmlspecialchars($_POST["challengeDeleteID"]);
    $updatestmt->execute();
    header("Refresh:0");
}


$new_result = $conn->query($getItemsUsed);


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
<form action="itemsUsed.php" method=POST>
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

<form action="itemsUsed.php" method=POST>
<p>Add a new used item here</p>
<input type="text" name="soldItemInsertID" placeholder="ItemSoldID" method=POST/>
<input type="text" name="challengeInsertID" placeholder="ChallengeID" method=POST/>
<input type="submit" name="insertItemUsed" value="Add New Used Item" method=POST/>
</form>

<form action="itemsUsed.php" method=POST>
<p>Delete used item</p>
<input type="text" name="soldItemDeleteID" placeholder="ItemSoldID" method=POST/>
<input type="text" name="challengeDeleteID" placeholder="ChallengeID" method=POST/>
<input type="submit" name="deleteItemUsed" value="Delete Used Item" method=POST/>
</form>


<?php
}
?>
