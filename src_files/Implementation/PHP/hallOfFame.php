<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="basic.css">
</head>
<body>
    <h1>Hall of Fame</h1>
    
<?php 
     $host = "localhost";
     $user = "christiansmac"; //REMEMBER TO CHANGE THIS TO WEBUSER CREDENTIALS
     $pass = "dweedwee";
     $dbse = "pokemon_league";

     if (!$conn = new mysqli($host, $user, $pass, $dbse)){
         echo "Error: Failed to make a MySQL connection: " . "<br>";
         echo "Errno: $conn->connect_errno; i.e. $conn->connect_error \n"; exit;
         }
    
    $getHall = "SELECT * FROM hall_of_fame;";

    //$bigdelete = "DELETE FROM items;";
    $result = $conn->query($getHall);

    // Prepare the delete statement
    //$stmt = $conn->prepare("DELETE FROM items WHERE item_id = ?;");
    //$stmt->bind_param('i', $id);
    //$stmt2 = $conn->prepare($bigdelete);





$all_results = $result->fetch_all();
$all_results_rows = $result->num_rows;


$new_result = $conn->query($getHall);


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
<form action="hallOfFame.php" method=POST>
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


<?php
}
?>