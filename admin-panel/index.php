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

  if($_SESSION["loggedin"] != "admin"){
    echo"You are not logged in. Please <a href='../login'>Login</a>";
    exit();
  }

  $username = $_SESSION["user"]["username"];
  $password = $_SESSION["user"]["password"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
  <center>
    <h1>Admin Page</h1>

    <table class='table'>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Date</th>
          <th>Number of questions</th>
            <th>Add Users</th>
            <th>Edit Tests</th>
        </tr>
      </thead>

      <tbody>
        <?php 
          $sql = "SELECT * FROM tests";
          $result = mysqli_query($conn, $sql);

          if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $testID =  $row["test_id"];
              echo "<tr>
                        <td>{$row["test_id"]}</td>
                        <td>{$row["test_name"]}</td>
                        <td>{$row["test_date"]}</td>
                        <td>{$row["test_question_no"]}</td>
                        <td>
                            <form action='/Portal/admin-panel/upload/index.php?testID={$testID}' method='post' enctype='multipart/form-data'>
                                <input type='file' name='csvFile' id='csvFil' accept='.csv'>
                                <button class='btn btn-primary' type='submit' name='submit'>Add Users</button>
                            </form>
                        </td>
                        <td>
                            <button class='btn btn-primary' id={$row["test_id"]} onClick='handleEdit(this.id)'>Edit</button>
                        </td>
                    </tr>";
            }
          }
        ?>

        <script>
          function handleEdit(id){
            window.location.href = "edit.php?testID=" + encodeURIComponent(id);
          }
        </script>
      </tbody>

    </table>

    <p>Create a <a href="create_test.php">test</a>.</p>
    <a href="../logout" class='btn btn-danger'>Logout</a>
  </center>
</body>
</html>