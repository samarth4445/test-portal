<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "portal";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION["user"])) {
  echo json_encode(['error' => 'You are not logged in. Please log in.']);
  exit();
}

if (!isset($_SESSION["loggedin"])) {
  echo json_encode(['error' => 'You are not logged in. Please log in.']);
  exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["curr_answer"])) {
  $currAnswer = $data["curr_answer"];
  $userOption = mysqli_real_escape_string($conn, $currAnswer["user_option"]);
  $questionID = mysqli_real_escape_string($conn, $currAnswer["question_id"]);
  $userID = $_SESSION["userID"];

  // Use prepared statements to prevent SQL injection
  $sql = "SELECT * FROM useranswers WHERE question_id=? AND user_id=?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ii", $questionID, $userID);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);

  if (mysqli_stmt_num_rows($stmt) > 0) {
    $sql = "UPDATE useranswers SET user_option=? WHERE user_id=? AND question_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $userOption, $userID, $questionID);
    mysqli_stmt_execute($stmt);

    echo json_encode(['status' => 'success', 'message' => 'Question updated successfully']);
  } else {
    $sql = "INSERT INTO useranswers(user_id, question_id, user_option) VALUES(?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $userID, $questionID, $userOption);
    mysqli_stmt_execute($stmt);

    echo json_encode(['status' => 'success', 'message' => 'Question added successfully']);
  }
}
