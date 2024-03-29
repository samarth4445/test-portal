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

if ($_SESSION["loggedin"] != "user") {
  echo "You are not logged in. Please <a href='../login'>Login</a>";
  exit();
}

if (!isset($_SESSION["userID"])) {
  echo "You are not logged in. Please <a href='../login'>Login</a>";
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

if ($testID == -1) {
  echo "You have not been registered in any of the tests.";
} else {
  $sql = "SELECT * FROM tests WHERE test_id={$testID}";
  $result = mysqli_query($conn, $sql);

  $testName = "";

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $testName = $row["test_name"];
    }
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

if ($testStatus == -1) {
    echo "<h1>You have not been registered for any tests</h1>";
    echo "<a href='/Portal/logout'>Go to the log in page...</a>";
    // header("Location: /Portal/logout");
    exit();
} else if ($testStatus == 2) {
    header("Location: /Portal/error/test-given-already");
    exit();
}

$questions = [];

$sql = "SELECT * FROM questions WHERE test_id={$testID}";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $question_text = $row["question"];
    $questionID = $row["question_id"];
    $op1 = $row["op1"];
    $op2 = $row["op2"];
    $op3 = $row["op3"];
    $op4 = $row["op4"];

    $question = array(
      "question_id" => $questionID,
      "question" => $question_text,
      "op1" => $op1,
      "op2" => $op2,
      "op3" => $op3,
      "op4" => $op4,
    );

    array_push($questions, $question);
  }

  $question_no = count($questions);
  shuffle($questions);

  $savedAnswers = [];

  $sql = "SELECT * FROM useranswers WHERE user_id={$userID}";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $currOption = [
        "question_id" => $row["question_id"],
        "user_option" => $row["user_option"],
      ];

      array_push($savedAnswers, $currOption);
    }
  }

  // for ($i = 0; $i < count($savedAnswers); $i++) {
  //   echo $savedAnswers[$i]["question_id"] . " ";
  // }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>
    <?php
    echo $testName;
    ?>
  </title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="../assets/images/favicon.png">
  <link rel="stylesheet" href="test-style.css" />
</head>

<body>
  <nav>
    <div class="nav-div">
      <div class="nav-content">
        <img src="hi.png" alt="" />
        <p id="time-p">1:00:00</p>
      </div>
    </div>
  </nav>
  <script src="scripts/time.js"></script>
  <div class="parent">
    <div class="pallette-div">
      <div id="column-pallette" class="column-pallette">
      </div>
      <button class="saveandnext" onclick="finishTest()">Finish Test</button>
    </div>
    <div class="question-div">
      <p id="question-number" class="question-number">
        Question 1 / <?php echo $question_no ?>
      </p>
      <p id="question-para" class="question-text">
        <?php echo $questions[0]["question"]; ?>
      </p>
      <label class="custom-radio-btn">
        <span id="op1" class="label">
          <?php echo  $questions[0]["op1"]; ?>
        </span>
        <input type="radio" name="answer" value="op1" id="op1-r" />
        <span class="checkmark"></span>
      </label>
      <label class="custom-radio-btn">
        <span id="op2" class="label">
          <?php echo  $questions[0]["op2"]; ?>
        </span>
        <input type="radio" name="answer" value="op2" id="op2-r" />
        <span class="checkmark"></span>
      </label>
      <label class="custom-radio-btn">
        <span id="op3" class="label">
          <?php echo  $questions[0]["op3"]; ?>
        </span>
        <input type="radio" name="answer" value="op3" id="op3-r" />
        <span class="checkmark"></span>
      </label>
      <label class="custom-radio-btn">
        <span id="op4" class="label">
          <?php echo  $questions[0]["op4"]; ?>
        </span>
        <input type="radio" name="answer" value="op4" id="op4-r" />
        <span class="checkmark"></span>
      </label>

      <div class="navigation-button">
        <button name="saveandnext" id="save" class="saveandnext" onclick="handleSave()">Save</button>
        <button name="saveandnext" id="saveandnext" class="saveandnext" onclick="handleSaveAndNext()">Save and Next</button>
        <button name="saveandnext" id="next" class="saveandnext" onclick="handleNext()">Next</button>
        <button name="goback" id="goback" class="saveandnext" onclick="handleBack()">Go Back</button>
      </div>
    </div>
  </div>
  <script>
    let currQuestion = 0;
    let questions = <?php echo json_encode($questions); ?>;
    let question_no = questions.length;
    const getAnswers = <?php echo json_encode($savedAnswers); ?>;
    const savedAnswers = [];

    const question_number = document.getElementById("question-number");
    const question_para = document.getElementById("question-para");
    const op1 = document.getElementById("op1");
    const op2 = document.getElementById("op2");
    const op3 = document.getElementById("op3");
    const op4 = document.getElementById("op4");
    const op1_r = document.getElementById("op1-r");
    const op2_r = document.getElementById("op2-r");
    const op3_r = document.getElementById("op3-r");
    const op4_r = document.getElementById("op4-r");
    const butnext = document.getElementById("next");
    const goback = document.getElementById("goback");

    for (let i = 0; i < getAnswers.length; i++) {
      let whatIsAnswer = {
        question_id: Number(getAnswers[i]["question_id"]),
        user_option: Number(getAnswers[i]["user_option"]),
      }
      savedAnswers.push(whatIsAnswer)
    }

    const finishTest = () => {
      getResponse = prompt("Are you sure you want to finish the Test? Type 'Yes' in the following input box.").toLowerCase();

      console.log(getResponse);

      if (getResponse == "yes") {
        window.location.href = "finish";
      }
    }

    const handleQuestionPalletteClick = (whatIsCurrQuestion) => {
      currQuestion = whatIsCurrQuestion - 1;
      question_number.innerHTML = "Question " + (currQuestion + 1) + " / " + question_no;
      question_para.innerHTML = questions[currQuestion]["question"];
      // console.log(currQuestion);

      op1.innerHTML = questions[currQuestion]["op1"];
      op2.innerHTML = questions[currQuestion]["op2"];
      op3.innerHTML = questions[currQuestion]["op3"];
      op4.innerHTML = questions[currQuestion]["op4"];

      const markThisDivUnanswered = document.getElementById(questions[currQuestion]["question_id"]);

      if (!markThisDivUnanswered.classList.contains("answered")) {
        markThisDivUnanswered.classList.add("not-answered");
      }

      markValuesWhenReload();
    }

    const column_pallette = document.getElementById("column-pallette");
    column_pallette.innerHTML = "";

    for (let i = 0; i < questions.length; i++) {
      const individual_question = document.createElement("div");
      individual_question.className = "individual-question";
      individual_question.id = questions[i]["question_id"];
      individual_question.innerHTML = i + 1;

      individual_question.addEventListener("click", function() {
        handleQuestionPalletteClick(individual_question.innerHTML);
      });

      if (i == 0) {
        individual_question.classList.add("not-answered");
      }

      for (let j = 0; j < savedAnswers.length; j++) {
        if (questions[i]["question_id"] == savedAnswers[j]["question_id"]) {
          if (individual_question.classList.contains("not-answered")) {
            individual_question.classList.remove("not-answered")
          }
          individual_question.classList.add("answered");
        }
      }

      column_pallette.appendChild(individual_question);
    }
    // console.log(questions[0]["question_id"]);

    console.log(savedAnswers);

    const markPallette = (question_id) => {
      const markThisDiv = document.getElementById(question_id);
      markThisDiv.classList.add("answered");
    }

    const markValuesWhenReload = () => {
      op1_r.checked = false;
      op2_r.checked = false;
      op3_r.checked = false;
      op4_r.checked = false;

      let flag = -1;

      for (let i = 0; i < savedAnswers.length; i++) {
        if (questions[currQuestion]["question_id"] == savedAnswers[i]["question_id"]) {
          console.log(savedAnswers[i]["user_option"]);
          flag = savedAnswers[i]["user_option"];
        }
      }

      if (flag === 1) {
        op1_r.checked = true;
      } else if (flag === 2) {
        op2_r.checked = true;
      } else if (flag === 3) {
        op3_r.checked = true;
      } else if (flag === 4) {
        op4_r.checked = true;
      }
    }

    markValuesWhenReload();

    const handleSave = () => {
      let user_option = -1;

      if (op1_r.checked) {
        user_option = 1;
      } else if (op2_r.checked) {
        user_option = 2;
      } else if (op3_r.checked) {
        user_option = 3;
      } else {
        user_option = 4;
      }

      let currAnswer = {
        question_id: questions[currQuestion]["question_id"],
        user_option: user_option,
      }

      fetch("/portal/user/test/send_answer.php", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            curr_answer: currAnswer,
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
          return error.text();
        });

      let flag2 = 0;

      for (let i = 0; i < savedAnswers.length; i++) {
        if (savedAnswers[i]["question_id"] === questions[currQuestion]["question_id"]) {
          savedAnswers[i]["user_option"] = user_option;
          flag2 = 1;
        }
      }

      if (!flag2) {
        savedAnswers.push({
          question_id: questions[currQuestion]["question_id"],
          user_option: user_option,
        })
      }

      markPallette(questions[currQuestion]["question_id"]);

      const currQuestionIndPallette = document.getElementById(questions[currQuestion]["question_id"]);
      if (currQuestionIndPallette.classList.contains("not-answered")) {
        currQuestionIndPallette.classList.remove("not-answered");
      }
      currQuestionIndPallette.classList.add("answered");
    }

    const handleSaveAndNext = () => {
      handleSave();
      handleNext();
    }

    const handleNext = () => {
      currQuestion++;
      goback.disabled = false;

      if (currQuestion >= question_no) {
        currQuestion = question_no - 1;
        // console.log("Completed");
        butnext.disabled = true;
        return;
      }
      question_number.innerHTML = "Question " + (currQuestion + 1) + " / " + question_no;
      question_para.innerHTML = questions[currQuestion]["question"];
      // console.log(currQuestion);

      op1.innerHTML = questions[currQuestion]["op1"];
      op2.innerHTML = questions[currQuestion]["op2"];
      op3.innerHTML = questions[currQuestion]["op3"];
      op4.innerHTML = questions[currQuestion]["op4"];

      const markThisDivUnanswered = document.getElementById(questions[currQuestion]["question_id"]);

      if (!markThisDivUnanswered.classList.contains("answered")) {
        markThisDivUnanswered.classList.add("not-answered");
      }

      markValuesWhenReload();
    }

    const handleBack = () => {
      currQuestion--;
      butnext.disabled = false;

      if (currQuestion < 0) {
        currQuestion = 0;
        // console.log("Cannot go back anymore");
        goback.disabled = true;
        return;
      }

      question_number.innerHTML = "Question " + (currQuestion + 1) + " / " + question_no;
      question_para.innerHTML = questions[currQuestion]["question"];
      // console.log(currQuestion);

      op1.innerHTML = questions[currQuestion]["op1"];
      op2.innerHTML = questions[currQuestion]["op2"];
      op3.innerHTML = questions[currQuestion]["op3"];
      op4.innerHTML = questions[currQuestion]["op4"];

      const markThisDivUnanswered = document.getElementById(questions[currQuestion]["question_id"]);


      if (!markThisDivUnanswered.classList.contains("answered")) {
        markThisDivUnanswered.classList.add("not-answered");
      }

      markValuesWhenReload();
    }
  </script>
</body>

</html>