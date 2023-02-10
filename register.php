<?php
if(preg_match("/^[A-Za-z0-9\s]{8,200}$/", $_POST['username'])){
    if(preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $_POST['email'])){
        if($_POST['password'] == $_POST['password_repeat']){
           if(preg_match("/^(?=.*[A-Z])(?=.*[!@#+$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$/", $_POST['password'])){
            
                require_once("connectdb.php");
                $info = array(':email' => strtolower($_POST['email']));
                $comm = "SELECT COUNT(*) FROM user where email=:email;";
                $stmt = $pdo->prepare($comm);
                $stmt->execute($info);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row['COUNT(*)'] == 1) {
                    echo "This email already used!";
                } else {
                    $info = array(':username' => strtolower($_POST['username']), ':email' => strtolower($_POST['email']), ':password' => ($_POST['password']));
                    $comm = "INSERT INTO user(username,email,password,isactive,type) VALUES (:username,:email,:password,'inactive','user');";
                    $stmt = $pdo->prepare($comm);
                    $stmt->execute($info);
                    echo "registration sccessfully";
                }
         }else{
                echo "password must be hard";
            }
        }else{
            echo "passwords not match";
        }
    }else{
        echo "You have entered an invalid email address!";
    }
}else{
    echo "username must contain only letters or numbers and length between 8-100!";
}
?>