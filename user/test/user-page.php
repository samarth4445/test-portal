<?php
  $db_server = "localhost";
  $db_user = "root";
  $db_pass = "";
  $db_name = "portal";
  $conn = "";
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

  if($_SESSION["loggedin"] != "user"){
    echo"You are not logged in. Please <a href='../login'>Login</a>";
    exit();
  }

  if(!isset($_SESSION["userID"])){
    echo"You are not logged in. Please <a href='../login'>Login</a>";
    exit();
  }

  $username = $_SESSION["user"]["username"];
  $password = $_SESSION["user"]["password"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>User Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
  <?php
    echo "<p>    Username:     {$username}</p>"
  ?>
  <center>
    <h1>Tests</h1>
    <table class='table'>
      <thead>
        <tr>
          <th>Test ID</th>
          <th>Test Name</th>
          <th>Date</th>
          <th>Give Test</th>
        </tr>
      </thead>

      <tbody>
        <?php 
          $sql = "SELECT t.*
                  FROM tests t
                  JOIN usertests ut ON t.test_id = ut.test_id
                  WHERE ut.user_id = {$_SESSION["userID"]};";
          $result = mysqli_query($conn, $sql);

          if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
              echo "<tr><td>{$row["test_id"]}</td><td>{$row["test_name"]}</td><td>{$row["test_date"]}</td><td><button class='btn btn-primary' id={$row["test_id"]} onClick='goToTest(this.id)'>Go to Test</button></td></tr>";
            }
          }
        ?>

        <script>
          function goToTest(id){
            window.location.href = "give_test.php?testID=" + encodeURIComponent(id);
          }
        </script>
      </tbody>

    </table>
  </center>
</body>
</html>