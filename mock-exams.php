
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

	$sql = "Select t_id, t_title from test_db.exam_topic";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		echo '<form action="'. $_SERVER["PHP_SELF"]. '" method="POST">';
  		echo 'select exam:';
		echo '<select name="exam_options">';
			while($row = $result->fetch_assoc())
			{
  				echo '<option value="' .$row["t_id"]. '">' .$row["t_title"]. '</option>';
			}
  		echo'</select>';
		echo'<br><br>';
  		echo '<input type="submit" value="Submit">';
		echo '</form>';
	}
?>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){

	$sql = "Select etl_id from test_db.exam_topic_level where t_id=" .$_POST["exam_options"];
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row1 = $result->fetch_assoc();
		$sql = "Select q_id from test_db.exam_level_question where etl_id = ". $row1["etl_id"];
		$exam_l_q = $conn->query($sql);
		while($row2 = $exam_l_q->fetch_assoc()) {
        		$sql = "Select q_title, q_active from test_db.exam_question where q_id = '". $row2["q_id"]. "' and q_active = 'Y'";
			echo $sql;
			$exam_q = $conn->query($sql);
			while($row3 = $exam_q->fetch_assoc()) {
				echo 'id: ' . $row2["q_id"]. ' - : ' . $row3["q_title"]. ' ' . $row3["q_active"]. '<br>';
			}
    		}
	}
}
$conn->close(); 
?>

</div> 
</body>
</html>