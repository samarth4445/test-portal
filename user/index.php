<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "portal";
$conn = "";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

session_start();
if (!isset($_SESSION["user"])) {
  echo "You are not logged in. Please <a href='../login'>Login</a>";
  exit();
}

if (!isset($_SESSION["loggedin"])) {
  echo "You are not logged in. Please <a href='../login'>Login</a>";
  exit();
}

if ($_SESSION["loggedin"] != "user") {
  echo "You are not logged in. Please <a href='../login'>Login</a>";
  exit();
}

if (!isset($_SESSION["userID"])) {
  echo "You are not logged in. Please <a href='../login'>Login</a>";
  exit();
}

$username = $_SESSION["user"]["username"];
$password = $_SESSION["user"]["password"];

$testID = -1;
$userID = $_SESSION["userID"];
$sql = "SELECT * FROM usertests WHERE user_id={$userID}";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $testID = $row["test_id"];
  }
}

//if ($testID == -1) {
//  echo "You have not been registered in any of the tests.";
//} else {
$sql = "SELECT * FROM tests WHERE test_id={$testID}";
$result = mysqli_query($conn, $sql);

$testName = "";

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $testName = $row["test_name"];
  }
}
//}

$instruction = "";
$sql = "SELECT * FROM instructions WHERE test_id={$testID}";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $instruction = $row["instruction"];
  }
}

$sql = "SELECT * FROM test_status WHERE user_id={$userID} AND test_id={$testID}";
$result = mysqli_query($conn, $sql);

$testStatus = -1;

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $testStatus = $row["test_status"];
  }
}

if ($testStatus == -1) {
  echo "<h1>You have not been registered for any tests</h1>";
  echo "<a href='/Portal/logout'>Go to the log in page...</a>";
  // header("Location: /Portal/logout");
  exit();
} else if ($testStatus == 2) {
  header("Location: /Portal/error/test-given-already");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Sokalp - Test</title>
  <link rel="stylesheet" href="user-style.css" />
</head>

<body>
  <nav>
    <div class="nav-div">
      <img src="hi.png" alt="" />
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
      <!-- <link rel="icon" type="image/x-icon" href="../assets/images/favicon.png"> -->
      <link rel="stylesheet" href="style.css" />
    </div>
    <div class="parent">
      <div class="container">
        <h1><?php echo $testName; ?> Test</h1>
      </div>
      <div class="container">
        <p class="initial-heading">Instructions</p>
        <p class="initial-instructions">
          <?php echo $instruction; ?>
        </p>
        <p class="regards">Good Luck!</p>
        <div class="buttons">
          <button class="btn btn-start-test" onclick="handleStartTest()">Start Test</button>
          <button class="btn btn-logout" onclick="handleLogout()">Logout</button>
        </div>
      </div>
    </div>

    <script>
      const handleLogout = () => {
        window.location.href = "../logout";
      }

      const handleStartTest = () => {
        window.location.href = "test";
      }
    </script>
</body>

</html>