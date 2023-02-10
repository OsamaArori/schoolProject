<?php
    session_start();
    require_once("connectdb.php");
    $info = array(':id' => $_SESSION["id"]);
    $comm = "SELECT * FROM user WHERE type !='admin' and id != :id;";
    $stmt = $pdo->prepare($comm);
    $stmt->execute($info);

    $commMe = "SELECT * FROM user WHERE id = :id;";
    $stmtMe = $pdo->prepare($commMe);
    $stmtMe->execute($info);
    
    $data = array();
    $data['allusers'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $data['user'] = $stmtMe->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
?>
