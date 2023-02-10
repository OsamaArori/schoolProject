<?php
    session_start();
    require_once("connectdb.php");
    $info = array(':id' => $_SESSION["id"]);
    $comm = "SELECT name,passMark,mark FROM subject,stu_sub WHERE userId=:id AND id=subjectId";
    $stmt = $pdo->prepare($comm);
    $stmt->execute($info);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
