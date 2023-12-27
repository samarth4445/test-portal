<?php
  $db_server = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "portal";
  $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
  
  session_start();
  
  if(!isset($_SESSION["user"])){
    echo"You are not logged in. Please <a href='../login'>Login</a>";
    exit();
  }

  if(!isset($_SESSION["loggedin"])){
    echo"You are not logged in. Please <a href='../login'>Login</a>";
    exit();
  }

  if($_SESSION["loggedin"] != "admin"){
    echo"You are not logged in. Please <a href='../login'>Login</a>";
    exit();
  }

  $questionID = (int)isset($_GET['questionID']) ? $_GET['questionID'] : '';

  $sql = "SELECT * FROM questions WHERE question_id={$questionID}";
  $result = mysqli_query($conn, $sql);

  $test_id = 0;

  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      $test_id = $row["test_id"];
    }
  }

  $sql = "DELETE FROM questions WHERE question_id={$questionID}";
  $result = mysqli_query($conn, $sql);

  $sql = "SELECT * FROM tests WHERE test_id={$test_id}";
  $result = mysqli_query($conn, $sql);

  $row_number = 0;

  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      $row_number = $row["test_question_no"];
    }
  }

  $row_number--;

  $sql = "UPDATE tests SET test_question_no = {$row_number} WHERE test_id = {$test_id}";
  $result = mysqli_query($conn, $sql);

  header("Location: edit.php?testID={$test_id}");
?>