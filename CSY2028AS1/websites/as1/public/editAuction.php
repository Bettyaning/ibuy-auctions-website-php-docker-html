<?php
require '../header.php';

?>
<?php

$server ='mysql';
$username = 'student';
$password = 'student';

$schema = 'as1';

$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);

if (isset($_POST['submit'])) {
    $stmt = $pdo-> prepare('UPDATE as1.auction
                                SET auctionID = :auctionID, description = :description, categoryId = :categoryId, endDate = :endDate
                                WHERE auctionID = :auctionID');


$values = [
    'auctionID' => $_POST['auctionID'],  
    'title' => $_POST['title'],
    'description' => $_POST['description'],
    'categoryId' => $_POST['categoryId'],
    'endDate' => $_POST['endDate'],
];

$stmt ->execute($values);

echo ' <p>' . $_POST['title'] . ' auction has been successfully EDITED </p>';

echo '<a href="index.php"> Back to Homepage</a>';

}




else if(isset($_GET['auctionID'])) {

$auctionStmt = $pdo->prepare('SELECT * FROM as1.auction WHERE auctionID = :auctionID');



$values = [
    'auctionID' => $_GET['auctionID']
];


$auctionStmt->execute($values);

$auction = $auctionStmt->fetch();

    ?>
<form action ="editauction.php" method="POST">
    <input type="hidden" name="auctionID" value="<?php echo $auction['auctionID']; ?>"/>

<label>auction title </label>
<input type="text" name="title" value="<?php echo $auction['title']; ?>"/>

<label>auction title </label>
<textarea name="description"> <?php echo $auction['description']; ?> </textarea>


<label>Category: </label>
<select name="categoryId">





<?php

$stmt = $pdo->prepare('SELECT * FROM as1.category');
$stmt->execute();

foreach ($stmt as $row){
    if ($row['categoryId'] == $Category['categoryId']){
        echo'<option value="' . $row['categoryId'] . '" selected="selected">' . $row['name'] . '</option>';
    }
    else {
        echo'<option value="' . $row['categoryId'] . '">'. $row['name'] . '</option>';
    }
}


?>


</select>



<label>End Date: </label>
<input type="date" name="endDate"/>

<input type="submit" value="submit" name="submit"/>

</form>



<?php
}
?>


<?php
require '../footer.php';
?>

