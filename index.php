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

function redirect($url)
{
  header('Location: ' . $url);
  die();
}

if (isset($_SESSION["user"])) {
  if (isset($_SESSION["loggedin"])) {
    if ($_SESSION["loggedin"] == "admin") {
      redirect("/portal/admin-panel");
      exit();
    }
    else if($_SESSION["loggedin"] == "user"){
      redirect("/portal/user");
      exit();
    }
  }
  else{
    redirect("/portal/login");
    exit();
  }
}
else{
  redirect("/portal/login");
  exit();
}

