<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "portal";
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Edit Tests</title>
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
            echo "<h1>{$row['test_name']} Test</h1>";
          }
        }
        echo "<script>let testID = {$testID}</script>";
        ?>
        <table class='table'>
          <thead>
            <th>Question</th>
            <th>Option 1</th>
            <th>Option 2</th>
            <th>Option 3</th>
            <th>Option 4</th>
            <th>Delete Question</th>
          </thead>

          <tbody>
            <?php
            $testID = (int)isset($_GET['testID']) ? $_GET['testID'] : '';

            $sql = "SELECT * FROM questions WHERE test_id={$testID}";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>{$row['question']}</td><td>{$row['op1']}</td><td>{$row['op2']}</td><td>{$row['op3']}</td><td>{$row['op4']}</td><td><button class='btn btn-danger' id='{$row['question_id']}' onClick='handleDelete(this.id)'>Delete</button></td></tr>";
              }
            }
            ?>
          </tbody>
        </table>
        <br><br>
        <button class='btn btn-success mb-3' onClick="generateInput()">Add Question</button>

        <div id="inputContainer"></div>
      </center>

      <script>
        function handleDelete(id) {
          window.location.href = "delete_question.php?questionID=" + encodeURIComponent(id);
        }

        function addQuestion() {
          let questions = document.getElementById("question").value;
          let op1 = document.getElementById("op1").value;
          let op2 = document.getElementById("op2").value;
          let op3 = document.getElementById("op3").value;
          let op4 = document.getElementById("op4").value;

          console.log(testID);

          let question = {
            question: questions,
            test_id: testID,
            op1: op1,
            op2: op2,
            op3: op3,
            op4: op4
          }

          fetch('/portal/admin-panel/add_question.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({
                data: question
              }),
            })
            .then(response => {
              if (!response.ok) {
                throw new Error('Network response was not ok');
              }
              return response.json();
            })
            .then(data => {
              console.log('PHP Response:', data);
            })
            .catch(error => {
              console.error('Error:', error);
              return error.text(); // Add this line to get the actual response text
            })

          window.location.reload(true);
        }

        function generateInput() {
          document.getElementById("inputContainer").innerHTML = "";

          var div1 = document.createElement("div");
          div1.className = "form-floating ms-5 me-5"
          div1.innerHTML = `
        <input class='form-control' type="text" name="question" id="question" placeholder='Enter a Question'>
        <label for="question">Enter Question</label> <br> <br>
      `;

          var div2 = document.createElement("div");
          div2.className = "form-floating ms-5 me-5"
          div2.innerHTML = `
        <input class='form-control' type="text" name="op1" id="op1" placeholder='Enter Option 1'>
        <label for="op1">Option 1</label> <br> <br>
      `;

          var div3 = document.createElement("div");
          div3.className = "form-floating ms-5 me-5"
          div3.innerHTML = `
        <input class='form-control' type="text" name="op2" id="op2" placeholder='Enter Option 2'>
        <label for="op2">Option 2</label> <br> <br>
      `;

          var div4 = document.createElement("div");
          div4.className = "form-floating ms-5 me-5"
          div4.innerHTML = `
        <input class='form-control' type="text" name="op3" id="op3" placeholder='Enter Option 3'>
        <label for="op3">Option 3</label> <br> <br>
      `;

          var div5 = document.createElement("div");
          div5.className = "form-floating ms-5 me-5"
          div5.innerHTML = `
        <input class='form-control' type="text" name="op4" id="op4" placeholder='Enter Option 4'>
        <label for="op3">Option 4</label> <br> <br>
      `;

          var button = document.createElement("button");
          button.className = 'btn btn-primary mb-3'
          button.onclick = addQuestion;
          button.innerHTML = "Add";

          document.getElementById("inputContainer").appendChild(div1);
          document.getElementById("inputContainer").appendChild(div2);
          document.getElementById("inputContainer").appendChild(div3);
          document.getElementById("inputContainer").appendChild(div4);
          document.getElementById("inputContainer").appendChild(div5);

          document.getElementById("inputContainer").appendChild(button);
        }
      </script>
</body>

</html>