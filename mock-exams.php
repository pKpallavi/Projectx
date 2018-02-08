<!DOCTYPE html>
<html>
<head>
<style>
div.container{
	width: 100%;
	border: 1px solid gray;
}
header,footer {
	padding: 1em;
	color: white;
	background-color: transparent;
	clear: left;
	text-align: center;
	border-bottom: 170px;
}
</style>
</head>

<body>
<div class="container">
<header>
<img style="float:left; height:80px; width:100px" src= "/projectx/exam_module/mock-exams.png" alt="InfoTekGuide Logo"></img>
<h1 style="color:red">InfoTekGuide</h1>
<br><p>IT Training for your career success</p>
</header>
<hr>
<h1>Mock exams</h1>
<p>Exam Topic drop down shows available exams topics.
<br><br> 
Exam Level drop down shows available exam levels.
<br><br> 
Example:
<br><ul>  
<li>Level 1 - for Beginner.  </li>
<li>Level 2 - for Intermediate. </li>
<li>Level 3 - for Expert. </li>
</ul>
<br>
Each Exam Level carries a different set of questions. 
<br><br> 
Answer all the questions and then press Submit button to see your test score.
<br>
</p>
<form action="$_SERVER["PHP_SELF"]">
  select exam:
	<select name="exam_options">
  		<option value="Jenkins">Jenkins Exam</option>
  		<option value="AWS">AWS Exam</option>
  		<option value="Hadoop">Hadoop exam</option>
  		<option value="QA">QA exam</option>
	</select> 
	<br><br>
  <input type="submit" value="Submit">
</form>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
	die("Connection failed: ".$conn->connect_error);
}
echo "Connected successfully";
$sql = "Select * from test_db.exam_question where q_id LIKE '%JEN%'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "Select query executed successfully";
} else {
    echo "Error creating database: " . $conn->connect_error;
}

$conn->close();
?>

</div> 
</body>
</html>