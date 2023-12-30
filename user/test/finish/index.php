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
    echo "You are not logged in. Please <a href='../login'>Log in</a>";
    exit();
}

if ($_SESSION["loggedin"] != "user") {
    echo "You are not logged in. Please <a href='../login'>Log in</a>";
    exit();
}

if (!isset($_SESSION["userID"])) {
    echo "You are not logged in. Please <a href='../login'>Log in</a>";
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

$sql = "SELECT * FROM test_status WHERE user_id={$userID} AND test_id={$testID}";
$result = mysqli_query($conn, $sql);

$testStatus = -1;

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $testStatus = $row["test_status"];
    }
}

if($testStatus == -1){
    echo"<h1>You have not been registered for any tests</h1>";
    header("Location: /Portal/logout");
    exit();
}
else if($testStatus == 2){
    echo"<h1>You have already given the test</h1>";
    echo "<a href='/Portal/logout'>Go to the log in page...</a>";
    exit();
}

echo $userID;
$sql = "UPDATE test_status SET test_status=2 WHERE user_id={$userID} AND test_id={$testID}";
$result = mysqli_query($conn, $sql);

header("Location: /Portal/logout");
