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

if ($_SESSION["loggedin"] != "admin") {
  echo "You are not logged in. Please <a href='../login'>Login</a>";
  exit();
}

$username = $_SESSION["user"]["username"];
$password = $_SESSION["user"]["password"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>User Info</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
  <a href="/portal/admin-panel" class='btn btn-link'><-- Back</a>
      <center>
        <?php
        $testID = (int)isset($_GET['testID']) ? $_GET['testID'] : '';
        $sql = "SELECT * FROM tests WHERE test_id={$testID}";

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<h1>User Info for {$row['test_name']} Test</h1>";
          }
        }
        echo "<script>let testID = {$testID}</script>";
        ?>

        <table class='table'>
          <thead>
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Score</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $testID = (int)isset($_GET['testID']) ? $_GET['testID'] : '';

            $sql = "SELECT * FROM tests WHERE test_id={$testID}";
            $result = mysqli_query($conn, $sql);

            $totalMarks = 0;

            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_assoc($result);
              $totalMarks = $row["test_question_no"];
            }

            $sql = "SELECT useranswers.user_id, useranswers.question_id, useranswers.user_option, questions.correct_op 
                FROM useranswers
                JOIN questions ON questions.question_id = useranswers.question_id
                WHERE test_id={$testID}
                ORDER BY useranswers.user_id";
            $result = mysqli_query($conn, $sql);

            $userInfo = [];

            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $userInfo[] = [
                  "user_id" => $row["user_id"],
                  "question_id" => $row["question_id"],
                  "user_option" => $row["user_option"],
                  "correct_op" => $row["correct_op"],
                ];
              }
            }

            $scores = [];

            for ($i = 0; $i < count($userInfo); $i++) {
              if (!isset($scores["{$userInfo[$i]["user_id"]}"])) {
                $scores["{$userInfo[$i]["user_id"]}"] = 0;
              }

              if ($userInfo[$i]["user_option"] == $userInfo[$i]["correct_op"]) {
                $scores["{$userInfo[$i]["user_id"]}"]++;
              }
            }

            foreach ($scores as $x => $y) {
              echo "<tr>
          <td>{$x}</td>
          <td>Rando Username</td>
          <td>{$y}</td>
        </tr>";
            }
            ?>
          </tbody>
        </table>
      </center>
</body>

</html>