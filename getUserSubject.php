<?php
    session_start();
    require_once("connectdb.php");
    $info = array();
    $id=$_GET["studentId"];
    $comm = "SELECT id,name,mark FROM subject,stu_sub WHERE userId='$id' AND id=subjectId and mark='null'";
    $stmt = $pdo->prepare($comm);
    $stmt->execute($info);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
