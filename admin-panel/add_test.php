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

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["data"])) {
    $dataArray = $data["data"];
    $testDetails = $data["test"];

    $sqlInsertTest = "INSERT INTO tests(test_name, test_date, test_question_no) VALUES ('{$testDetails['test_name']}', '{$testDetails['test_date']}', '{$testDetails['test_question_no']}')";

    if (mysqli_query($conn, $sqlInsertTest)) {
        $testId = mysqli_insert_id($conn);

        foreach ($dataArray as $data) {
            $sqlInsertQuestion = "INSERT INTO questions(test_id, question, op1, op2, op3, op4, correct_op) VALUES($testId, '{$data['question']}', '{$data['op1']}', '{$data['op2']}', '{$data['op3']}', '{$data['op4']}', 1)";
            
            if (!mysqli_query($conn, $sqlInsertQuestion)) {
                echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
                exit();
            }
        }

        echo json_encode(['status' => 'success', 'message' => 'Test added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
}
?>
