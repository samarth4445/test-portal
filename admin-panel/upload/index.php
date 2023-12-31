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


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["csvFile"])) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["csvFile"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is a CSV file
    if ($fileType != "csv") {
        echo "Only CSV files are allowed.";
        $uploadOk = 0;
    }

    // Move the file to the uploads directory
    if ($uploadOk) {
        $userIDs = [];
        if (move_uploaded_file($_FILES["csvFile"]["tmp_name"], $targetFile)) {
            $csvData = array_map('str_getcsv', file($targetFile));

            for($i=1; $i<count($csvData); $i++){
                $currData = $csvData[$i];

                $currData[0] = trim($currData[0]);
                $currData[1] = trim($currData[1]);
                $currData[2] = trim($currData[2]);

                $sql = "SELECT * FROM users_u WHERE username='{$currData[1]}'";
                $result = mysqli_query($conn, $sql);

                $flag = 0;

                if(mysqli_num_rows($result) == 0){
                    $sql = "INSERT INTO users_u(username, email, password) VALUES('{$currData[1]}', '{$currData[0]}', '${currData[2]}')";
                    $result = mysqli_query($conn, $sql);
                    $flag = 1;
                }

                $lastInsertedId = -1;

                if($flag == 1){
                    $lastInsertedId = mysqli_insert_id($conn);
                }
                else{
                    $sql = "SELECT * FROM users_u ORDER BY user_id DESC LIMIT 1";
                    $result = mysqli_query($conn, $sql);

                    $row = mysqli_fetch_assoc($result);
                    $lastInsertedId =  $row["user_id"];
                }

                $testID = (int)isset($_GET['testID']) ? $_GET['testID'] : '';

                $sql = "SELECT * FROM test_status WHERE user_id={$lastInsertedId} AND test_id={$testID}";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) == 0){
                    $sql = "INSERT INTO test_status(user_id, test_id, test_status) VALUES({$lastInsertedId}, {$testID}, 1)";
                    $result = mysqli_query($conn, $sql);
                }

                $sql = "SELECT * FROM usertests WHERE user_id={$lastInsertedId} AND test_id={$testID}";
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) == 0){
                    $sql = "INSERT INTO usertests(user_id, test_id) VALUES({$lastInsertedId}, {$testID})";
                    $result = mysqli_query($conn, $sql);
                }
            }
        }
    }
}

header("Location: /Portal/admin-panel");

