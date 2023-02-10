<?php
session_start();
require_once("connectdb.php");
$info = array(':email' => $_POST['email']);
$comm = "SELECT id,email,username,password,isactive,type FROM user WHERE email=:email";
$stmt = $pdo->prepare($comm);
$stmt->execute($info);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
            
if ($_POST["password"]== $row["password"]){
    if($row['isactive'] == "active"){
        $_SESSION['id']=$row['id'];
        echo json_encode($row['type']);
    }else{
        echo json_encode("Your account still not active!");
    }
} else {
    echo json_encode($row['password']);
}
?>