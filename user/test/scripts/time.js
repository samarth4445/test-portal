function getTime() {
  fetch("/portal/user/test/get_answer.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      curr_answer: currAnswer,
    }),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      console.log("PHP Response:", data);
    })
    .catch((error) => {
      console.error("Error:", error);
      return error.text();
    });
}
