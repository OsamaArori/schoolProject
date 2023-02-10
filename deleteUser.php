<?php
require_once("connectdb.php");
$info = array(':id' => $_GET['id']);
$comm = "DELETE FROM user WHERE id=:id";
$stmt = $pdo->prepare($comm);
$stmt->execute($info);

echo json_encode("The user removed successfully.");
?>
