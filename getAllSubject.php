<?php
    session_start();
    require_once("connectdb.php");
    $info = array();
    $comm = "SELECT * FROM subject";
    $stmt = $pdo->prepare($comm);
    $stmt->execute($info);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
