<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "portal";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

// Check the connection
// TODO: CHANGE QUESTION NUMBER QUESTIONS IN DATABASE WHEN QUESTION IS ADDED
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

// Check if the user is logged in
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

// Get JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);

// Check if the required data is present
if (isset($data["data"])) {
    $question = $data["data"];

    // Sanitize input data to prevent SQL injection
    $testId = mysqli_real_escape_string($conn, $question['test_id']);
    $questionText = mysqli_real_escape_string($conn, $question['question']);
    $op1 = mysqli_real_escape_string($conn, $question['op1']);
    $op2 = mysqli_real_escape_string($conn, $question['op2']);
    $op3 = mysqli_real_escape_string($conn, $question['op3']);
    $op4 = mysqli_real_escape_string($conn, $question['op4']);

    // Use prepared statement to prevent SQL injection
    $sqlInsertTest = "INSERT INTO questions(test_id, question, op1, op2, op3, op4, correct_op) VALUES (?, ?, ?, ?, ?, ?, 1)";
    
    $stmt = mysqli_prepare($conn, $sqlInsertTest);

    if ($stmt) {
        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, 'ssssss', $testId, $questionText, $op1, $op2, $op3, $op4);

        if (mysqli_stmt_execute($stmt)) {
            $sql = "SELECT * FROM tests WHERE test_id={$testId}";
            $result = mysqli_query($conn, $sql);
          
            $row_number = 0;
          
            if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_assoc($result)) {
                $row_number = $row["test_question_no"];
              }
            }
          
            $row_number++;
            
            $sql = "UPDATE tests SET test_question_no = {$row_number} WHERE test_id = {$testId}";
            $result = mysqli_query($conn, $sql);

            echo json_encode(['status' => 'success', 'message' => "Question added successfully. Rows: {$row_number}"]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error executing query: ' . mysqli_stmt_error($stmt)]);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error preparing statement: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
}

// Close the database connection
mysqli_close($conn);
?>
