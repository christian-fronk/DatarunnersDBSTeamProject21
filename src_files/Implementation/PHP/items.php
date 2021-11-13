<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="basic.css">
</head>
<body>
    <h1>Items</h1>
    
<?php 
    $host = "localhost";
       $user = "WEBUSER CREDS HERE"; //REMEMBER TO CHANGE THIS TO WEBUSER CREDENTIALS
       $pass = "WEBUSER PASS HERE";
       $dbse = "pokemon_league";

       if (!$conn = new mysqli($host, $user, $pass, $dbse)){
           echo "Error: Failed to make a MySQL connection: " . "<br>";
           echo "Errno: $conn->connect_errno; i.e. $conn->connect_error \n"; exit;
           }

    
    $getItems = "SELECT * FROM items;";
    //$bigdelete = "DELETE FROM items;";
    $result = $conn->query($getItems);

// Prepare the delete statement
//$stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?;");
//$stmt->bind_param('i', $id);
//$stmt2 = $conn->prepare($bigdelete);




$all_results = $result->fetch_all();
$all_results_rows = $result->num_rows;

if(isset($_POST["insertItem"])) {
    $insertstmt = $conn->prepare("INSERT INTO items (item_name,item_description,item_stock,item_cost,isActiveItem) VALUES (?,?,?,?,'1');");
    $insertstmt->bind_param('ssii', $name,$description,$stock,$cost);
    $name = $_POST["itemName"];
    $description = $_POST["itemDescription"];
    $stock = $_POST["itemStock"];
    $cost = $_POST["itemCost"];
    $insertstmt->execute();
    header("Refresh:0");
}

if(isset($_POST["updateItemName"])) {
    $updatestmt = $conn->prepare("UPDATE items SET item_name = ? WHERE item_id = ?;");
    $updatestmt->bind_param('si', $name,$itemid);
    $name = $_POST["itemNameUpdate"];
    $itemid = $_POST["itemNameID"];
    $updatestmt->execute();
    header("Refresh:0");
}

if(isset($_POST["updateItemDescription"])) {
    $updatestmt = $conn->prepare("UPDATE items SET item_description = ? WHERE item_id = ?;");
    $updatestmt->bind_param('si', $description,$itemid);
    $description = $_POST["itemDescriptionUpdate"];
    $itemid = $_POST["itemDescriptionID"];
    $updatestmt->execute();
    header("Refresh:0");
}

if(isset($_POST["updateItemStock"])) {
    $updatestmt = $conn->prepare("UPDATE items SET item_stock = ? WHERE item_id = ?;");
    $updatestmt->bind_param('ii', $stock,$itemid);
    $stock = $_POST["itemStockUpdate"];
    $itemid = $_POST["itemStockID"];
    $updatestmt->execute();
    header("Refresh:0");
}

if(isset($_POST["updateItemCost"])) {
    $updatestmt = $conn->prepare("UPDATE items SET item_cost = ? WHERE item_id = ?;");
    $updatestmt->bind_param('ii', $cost,$itemid);
    $cost = $_POST["itemCostUpdate"];
    $itemid = $_POST["itemCostID"];
    $updatestmt->execute();
    header("Refresh:0");
}



if(isset($_POST["updateItemActive"])) {
    $updatestmt = $conn->prepare("UPDATE items SET isActiveItem = ? WHERE item_id = ?;");
    $updatestmt->bind_param('ii', $active,$itemid);
    $active = $_POST["activePick"];
    $itemid = $_POST["itemActiveID"];
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



$new_result = $conn->query($getItems);


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
<form action="items.php" method=POST>
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

<form action="items.php" method=POST>
<p>Add a new Item here</p>
<input type="text" name="itemName" placeholder="Name" method=POST/>
<input type="text" name="itemDescription" placeholder="Description" method=POST/>
<input type="text" name="itemStock" placeholder="Stock" method=POST/>
<input type="text" name="itemCost" placeholder="Cost" method=POST/>
<input type="submit" name="insertItem" value="Add New Item" method=POST/>
</form>


<form action="items.php" method=POST>
<p>Update Item Name </p>
<input type="text" name="itemNameID" placeholder="itemID" method=POST/>
<input type="text" name="itemNameUpdate" placeholder="Name" method=POST/>
<input type="submit" name="updateItemName" value="Update Item Name" method=POST/>
</form>


<form action="items.php" method=POST>
<p>Update Item Description </p>
<input type="text" name="itemDescriptionID" placeholder="itemID" method=POST/>
<input type="text" name="itemDescriptionUpdate" placeholder="Description" method=POST/>
<input type="submit" name="updateItemDescription" value="Update Item Description" method=POST/>
</form>


<form action="items.php" method=POST>
<p>Update Item Stock </p>
<input type="text" name="itemStockID" placeholder="itemID" method=POST/>
<input type="text" name="itemStockUpdate" placeholder="Stock" method=POST/>
<input type="submit" name="updateItemStock" value="Update Item Stock" method=POST/>
</form>


<form action="items.php" method=POST>
<p>Update Item Cost </p>
<input type="text" name="itemCostID" placeholder="itemID" method=POST/>
<input type="text" name="itemCostUpdate" placeholder="Cost" method=POST/>
<input type="submit" name="updateItemCost" value="Update Item Cost" method=POST/>
</form>




<form action="items.php" method=POST>
<p>Update Item Active </p>
<input type="text" name="itemActiveID" placeholder="itemID" method=POST/>
  <label for="activePick">Choose status:</label>
  <select id="activePick" name="activePick">
    <option value="1">Active</option>
    <option value="0">Inactive</option>
  </select>
  <input type="submit" name="updateItemActive" value="Update Item Active" method=POST/>
</form>


<?php
}


?>
