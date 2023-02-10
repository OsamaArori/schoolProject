<?php
  $conn = new mysqli('localhost', 'root', '123456789', 'schooldb');
  if (isset($_POST['message'])) {
    $conn->query("INSERT INTO chat (message) VALUES ('" . $_POST['message'] . "')");
  }
  $result = $conn->query("SELECT * FROM chat ORDER BY id DESC");
  $messages = array();
  while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
  }
  session_start();
    require_once("connectdb.php");
    $info = array();
    $id=$_GET["studentId"];
    $comm = "SELECT * from chat";
    $stmt = $pdo->prepare($comm);
    $stmt->execute($info);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
  
?>