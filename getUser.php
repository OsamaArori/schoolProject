<?php
    session_start();
    require_once("connectdb.php");
    $info = array(':id' => $_GET["id"]);
    $commMe = "SELECT * FROM user WHERE id = :id;";
    $stmtMe = $pdo->prepare($commMe);
    $stmtMe->execute($info);
    
    $data = array();
    $data['user'] = $stmtMe->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
?>
