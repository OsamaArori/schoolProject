<?php
  function get_all_students() {
    // code to fetch all students from database
    return $students;
  }

  function update_student($student_id, $username, $email, $active) {
    
    if(preg_match("/^[A-Za-z0-9\s]{8,200}$/", $username)){
        if(preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $_POST['email'])){
            require_once("connectdb.php");
    $info = array( ':id' => strtolower($student_id),':username' => strtolower($username), ':email' => strtolower($email), ':isactive' => $active);
    $comm = "UPDATE user SET email=:email , username=:username, isactive=:isactive WHERE id=:id;";
    $stmt = $pdo->prepare($comm);
    $stmt->execute($info);
    echo json_encode("The user ".$email." Updated successfully.");
        }else{
            echo json_encode("You have entered an invalid email address!");
        }
    }else{
        echo json_encode("username must contain only letters or numbers and length between 8-100!");
    }



  }

  function delete_student($student_id) {
    
    require_once("connectdb.php");
    $info = array(':id' => $student_id);
    $comm = "DELETE FROM user WHERE id=:id";
    $stmt = $pdo->prepare($comm);
    $stmt->execute($info);

    echo json_encode("The user removed successfully.");


  }

  function create_student($username, $email, $password) {
    if(preg_match("/^[A-Za-z0-9\s]{8,200}$/", $username)){
        if(preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)){
            
               if(preg_match("/^(?=.*[A-Z])(?=.*[!@#+$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$/", $password)){
                
                    require_once("connectdb.php");
                    $info = array(':email' => strtolower($email));
                    $comm = "SELECT COUNT(*) FROM user where email=:email;";
                    $stmt = $pdo->prepare($comm);
                    $stmt->execute($info);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row['COUNT(*)'] == 1) {
                        echo "This email already used!";
                    } else {
                        $info = array(':username' => strtolower($username), ':email' => strtolower($email), ':password' => ($password));
                        $comm = "INSERT INTO user(username,email,password,isactive,type) VALUES (:username,:email,:password,'inactive','user');";
                        $stmt = $pdo->prepare($comm);
                        $stmt->execute($info);
                        echo "registration sccessfully";
                    }
             }else{
                    echo "password must be hard";
                }
            
        }else{
            echo "You have entered an invalid email address!";
        }
    }else{
        echo "username must contain only letters or numbers and length between 8-100!";
    }
  }

  function create_subject($subject_name, $min_mark) {
    if(preg_match("/^[A-Za-z0-9!@#+$&*\s]{2,200}$/", $subject_name)){
        if($min_mark <= 100 && $min_mark >= 2){
            require_once("connectdb.php");
    $info = array(':name' => strtolower($subject_name),':mark' => $min_mark);
    $comm = "INSERT INTO subject(name, passMark) VALUES (:name,:mark);";
    $stmt = $pdo->prepare($comm);
    $stmt->execute($info);
    echo json_encode("subject created");
        }else{
            echo json_encode("Please enter correct minimum mark 2-100");
        }
    }else{
        echo json_encode("Subject name must contain only letters or numbers or this symbols !@#+$&* and length between 2-100!");
    }
  }

  function assign_subject($userId, $subjectId) {
    require_once("connectdb.php");
    $info = array(':userId' => $userId,':subjectId' => $subjectId);
    $comm = "INSERT INTO stu_sub(userId, subjectId,mark) VALUES (:userId,:subjectId,'null');";
    $stmt = $pdo->prepare($comm);
    $stmt->execute($info);
    echo json_encode("The User added to the subject successfully.");
    }

    function set_mark($userId, $subjectId, $mark){
        
        if($mark >= 0 && $mark <= 100){
            require_once("connectdb.php");
        $info = array(':userId' => $userId,':subjectId' => $subjectId);
        $comm = "SELECT COUNT(*) FROM stu_sub where userId=:userId AND subjectId=:subjectId;";
        $stmt = $pdo->prepare($comm);
        $stmt->execute($info);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $info = array(':userId' => $userId,':subjectId' => $subjectId,':mark' => $mark);
        if($row["COUNT(*)"] >= 1){
            $comm = "UPDATE stu_sub SET mark=:mark where userId=:userId AND subjectId=:subjectId;";
            $stmt = $pdo->prepare($comm);
            $stmt->execute($info);
        }else{
        
        }
        echo json_encode("Mark added successfully.");
        }else{
            echo json_encode("Please set a correct mark");
        }

    }

  // handle ajax requests
  if (isset($_POST['action'])) {
    switch ($_POST['action']) {
      case 'update_student':
        update_student($_POST['student_id'], $_POST['username'], $_POST['email'], $_POST['active']);
        break;
      case 'delete_student':
        delete_student($_POST['student_id']);
        break;
      case 'create_student':
        create_student($_POST['username'], $_POST['email'], $_POST['password']);
        break;
      case 'create_subject':
        create_subject($_POST['subject_name'], $_POST['min_mark']);
        break;
        case 'assign_subject':
            assign_subject($_POST['studentId'], $_POST['subjectId']);
            break;
            case 'set_mark':
                set_mark($_POST['studentId'], $_POST['subjectId'],$_POST['mark']);
                break;
    }
  }
?>