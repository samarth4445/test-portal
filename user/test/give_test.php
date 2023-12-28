<?php
  $db_server = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "portal";
  $conn = "";
  $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

  session_start();
  if(!isset($_SESSION["user"])){
    echo"You are not logged in. Please <a href='index.php'>Login</a>";
    exit();
  }

  if(!isset($_SESSION["loggedin"])){
    echo"You are not logged in. Please <a href='index.php'>Login</a>";
    exit();
  }

  if($_SESSION["loggedin"] != "user"){
    echo"You are not logged in. Please <a href='index.php'>Login</a>";
    exit();
  }

  if(!isset($_SESSION["userID"])){
    echo"You are not logged in. Please <a href='index.php'>Login</a>";
    exit();
  }

  $username = $_SESSION["user"]["username"];
  $password = $_SESSION["user"]["password"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Give Test</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
  <center>
    <?php
      $testID = (int)isset($_GET['testID']) ? $_GET['testID'] : '';
      $sql = "SELECT * FROM currenttest";
      $isTestOn = false;

      $result = mysqli_query($conn, $sql);
      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
          if($testID == $row["test_id"]){
            $isTestOn = true;
          }
        }
      }

      if($isTestOn){
        echo "Test is On!";
      }
      else{
        echo "<h1>Wait for the admins to start the test!</h1>";
      }
    ?>
  </center>
</body>
</html>