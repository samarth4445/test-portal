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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Create a Test</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <style>
    h1 {
      margin-bottom: 30px;
    }

    .container-inside {
      display: grid;
      grid-template-columns: 1fr 1fr;
    }

    .container-main {
      width: 80%
    }
  </style>
</head>

<body>
  <a href="admin_page.php" class='btn btn-link'><-- Back</a>

      <center>
        <div class='container-main'>
          <h1>Create a Test</h1> <br> <br>

          <div class='form-floating ms-5 me-5'>
            <input class='form-control' type="text" name="test_name" id="test_name" placeholder='Data Structures and Algorithms'>
            <label for="test_name">Test Name</label>
          </div>

          <br><br>

          <div class='form-floating ms-5 me-5'>
            <input class='form-control' type="text" name="test_date" id="test_date" placeholder='YYYY-MM-DD'>
            <label for="test_date">Test Date</label>
          </div>

          <br><br>

          <div class='form-floating ms-5 me-5'>
            <input class='form-control' type="number" name="test_question_no" id="test_question_no" placeholder='69'>
            <label for="test_question_no">Number of Questions</label>
          </div>

          <br><br>

          <button class="btn btn-primary" onclick="startInputGeneration()">Create</button>
          <br><br>

          <div class='inputContainer' id="inputContainer">
          </div>

          <script>
            let currentInputIndex = 0;
            let totalInputs = 0;

            let questions = [];

            let startInputGeneration = () => {
              console.log(currentInputIndex);
              currentInputIndex = 0;
              totalInputs = parseInt(document.getElementById("test_question_no").value);
              document.getElementById("inputContainer").innerHTML = "";

              generateInput();
            }

            let sendQuestions = () => {
              let test_name = document.getElementById("test_name").value;
              let test_date = document.getElementById("test_date").value;
              let test_question_no = document.getElementById("test_question_no").value;

              console.log(test_name);
              console.log(test_date);
              console.log(test_question_no);

              let test_details = {
                test_name: test_name,
                test_date: test_date,
                test_question_no: test_question_no
              };

              fetch('/portal/admin-panel/add_test.php', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                  },
                  body: JSON.stringify({
                    data: questions,
                    test: test_details
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
            }

            let generateInput = () => {

              if (currentInputIndex > 0) {
                console.log(totalInputs);
                let question = {
                  question: document.getElementById("question").value,
                  op1: document.getElementById("op1").value,
                  op2: document.getElementById("op2").value,
                  op3: document.getElementById("op3").value,
                  op4: document.getElementById("op4").value,
                }

                questions.push(question);
              }

              if (currentInputIndex >= totalInputs) {
                sendQuestions();
                document.getElementById("inputContainer").innerHTML = "";
                return;
              }

              currentInputIndex = currentInputIndex + 1;
              document.getElementById("inputContainer").innerHTML = "";

              var header1 = document.createElement("h1");
              header1.className = "mb-3"
              header1.innerHTML = "Question " + (currentInputIndex);

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

              var container_inside = document.createElement("div");
              container_inside.className = "container-inside";
              container_inside.id = "container-inside";

              var button = document.createElement("button");
              button.className = 'btn btn-primary mb-3 button-next'
              button.onclick = generateInput;
              button.innerHTML = "Next Question";

              document.getElementById("inputContainer").appendChild(header1);
              document.getElementById("inputContainer").appendChild(div1);
              document.getElementById("inputContainer").appendChild(container_inside);
              document.getElementById("container-inside").appendChild(div2);
              document.getElementById("container-inside").appendChild(div3);
              document.getElementById("container-inside").appendChild(div4);
              document.getElementById("container-inside").appendChild(div5);

              document.getElementById("inputContainer").appendChild(button);
            }
          </script>
        </div>
      </center>
</body>

</html>