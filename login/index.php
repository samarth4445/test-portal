<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "portal";
$conn = "";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

// if($conn){
//   echo"Connected!";
// }

if (isset($_SESSION["user"]) || isset($_SESSION["loggedin"])) {
  header("location: /Portal/logout");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="../assets/images/favicon.png">
  <link rel="stylesheet" href="login.css" />
</head>

<body>
  <nav>
    <div class="nav-div">
      <img src="hi.png" alt="">
    </div>
  </nav>
  <div class="parent">
    <form method="post" class="login-main">
      <h1>Sign in</h1>

      <div class="inp inp-1">
        <label for="email">Enter your username</label>
        <input type="text" name="email" id="email" />
      </div>

      <div class="inp inp-2">
        <label for="password">Enter password</label>
        <input type="password" name="password" id="password" />
      </div>

      <button class="btn btn-sign-in" type="submit">Sign in</button>
      <p class="or">OR</p>
      <button class="btn btn-cwm">Continue with Google</button>
      <hr />
      <button class="btn btn-sign-up">Sign up</button>
      <p class="forgot-password">Forgot your password?</p>
    </form>
  </div>
</body>

</html>

<?php
function redirect($url)
{
  header('Location: ' . $url);
  die();
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["email"];
  $password = $_POST["password"];

  if ($username == "admin") {
    $sql = "SELECT * FROM users_a";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      $doesExist = false;

      while ($row = mysqli_fetch_assoc($result)) {
        if ($row["username"] == $username && $row["password"] == $password) {
          $doesExist = true;
        }
      }

      if ($doesExist) {
        $_SESSION["user"] = [
          "username" => $username,
          "password" => $password,
        ];
        $_SESSION["loggedin"] = "admin";
        redirect("../admin-panel");
      } else {
        echo "<center><p>Username or Password entered is incorrect!</p></center>";
      }
    }
  } else {
    $sql = "SELECT * FROM users_u";
    $result = mysqli_query($conn, $sql);
    $doesExist = false;
    $userID = -1;

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        if ($row["username"] == $username && $row["password"] == $password) {
          $doesExist = true;
          $userID = $row["user_id"];
        }
      }
    }
    if ($doesExist) {
      $_SESSION["user"] = [
        "username" => $username,
        "password" => $password
      ];

      $_SESSION["userID"] = $userID;
      $_SESSION["loggedin"] = "user";
      redirect("../user");
    } else {
      echo "<center><p>Username or Password entered is incorrect!</p></center>";
    }
  }
}
?>