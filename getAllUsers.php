<?php
    session_start();
    require_once("connectdb.php");
    $info = array();
    $comm = "SELECT id,username,type FROM user WHERE type!='admin'";
    $stmt = $pdo->prepare($comm);
    $stmt->execute($info);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
