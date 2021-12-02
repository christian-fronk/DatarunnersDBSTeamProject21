<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="solditems.css">
</head>
<body>
    <h1>Sold Items</h1>
    
<?php 
    $host = "localhost";
    $user = "WEBUSERCREDS"; //REMEMBER TO CHANGE THIS TO WEBUSER CREDENTIALS
    $pass = "PASSWORD";
    $dbse = "pokemon_league";

    if (!$conn = new mysqli($host, $user, $pass, $dbse)){
        echo "Error: Failed to make a MySQL connection: " . "<br>";
        echo "Errno: $conn->connect_errno; i.e. $conn->connect_error \n"; exit;
        }
        
    $getSoldItems = "SELECT * FROM sold_items;";
    //$bigdelete = "DELETE FROM items;";
    $result = $conn->query($getSoldItems);

// Prepare the delete statement
//$stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?;");
//$stmt->bind_param('i', $id);
//$stmt2 = $conn->prepare($bigdelete);




$all_results = $result->fetch_all();
$all_results_rows = $result->num_rows;

if(isset($_POST["insertSoldItem"])) {
    $insertstmt = $conn->prepare("INSERT INTO sold_items (item_id, trainer_id) VALUES (?,?);");
    $insertstmt->bind_param('ii', $item,$trainer);
    $item = htmlspecialchars($_POST["iID"]);
    $trainer = htmlspecialchars($_POST["tID"]);
    $insertstmt->execute();
    header("Refresh:0");
}

if(isset($_POST["deleteSoldItems"])) {
    $updatestmt = $conn->prepare("DELETE FROM sold_items WHERE item_sold_id = ?;");
    $updatestmt->bind_param('i',$sold);
    $sold = htmlspecialchars($_POST["soldItemDeleteID"]);
    $updatestmt->execute();
    header("Refresh:0");
}


$new_result = $conn->query($getSoldItems);


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
<form action="soldItems.php" method=POST>
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

<form action="soldItems.php" method=POST>
<p>Add a new sold item here</p>
<input type="text" name="iID" placeholder="ItemID" method=POST/>
<input type="text" name="tID" placeholder="TrainerID" method=POST/>
<input type="submit" name="insertSoldItem" value="Add New Sold Item" method=POST/>
</form>

<form action="soldItems.php" method=POST>
<p>Delete sold item</p>
<input type="text" name="soldItemDeleteID" placeholder="ItemSoldID" method=POST/>
<input type="submit" name="deleteSoldItems" value="Delete Sold Item" method=POST/>
</form>

<a href="/GroupPHP/index.php">Go back</a>

<?php
}
?>
