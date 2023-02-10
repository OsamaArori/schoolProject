<?php
    session_start();
    require_once("connectdb.php");
    $info = array();
    $id=$_GET["id"];
    $comm = "SELECT u.* from user as u where u.type!='admin' and id NOT IN (SELECT u.id from subject as s, user as u, stu_sub as su where u.id = su.userId and s.id = su.subjectId and s.id = '$id')";
    $stmt = $pdo->prepare($comm);
    $stmt->execute($info);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
