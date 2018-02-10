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
<img style="float:left; height:80px; width:100px" src= "/projectx/exam_module/mock-exams.png" alt="InfoTekGuide Logo">
<h1 style="color:red">InfoTekGuide</h1>
<br><p>IT Training for your career success</p>
</header>
<hr>
<h1>Mock exams</h1>
<p>Exam Topic drop down shows available exams topics.</p>
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

<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test_db";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if($conn->connect_error) {
            die("Connection failed: ".$conn->connect_error);
    }
    //echo "Connected successfully";

    echo '<form action="'. $_SERVER["PHP_SELF"]. '" method="POST" id="ch_exam">';                

    $sql = "Select t_id, t_title from test_db.exam_topic";
    $topic_selected = 0; $topic_id = 0;
    if(!empty($_POST["exam_options"]))
    {
        $topic_selected = 1;
        $topic_id = $_POST["exam_options"];
    }

    $level_selected = 0; $level_id = 0;
    if(!empty($_POST["exam_level_options"]))
    {
        $level_selected = 1;
        $level_id = $_POST["exam_level_options"];
    }
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
            //echo '<form action="'. $_SERVER["PHP_SELF"]. '" method="POST">';
            echo 'select exam:';
            //echo '<select name="exam_options" form="ch_exam" onchange="?action='. $_SERVER["PHP_SELF"]. '">';
            echo '<select name="exam_options" form="ch_exam" onchange="ch_exam.submit()">';
            while($row = $result->fetch_assoc())
            {                    
                    if($topic_selected == 1)
                    {
                        if($row["t_id"] == $topic_id)
                        {
                            echo '<option value="' .$row["t_id"]. '" selected>' .$row["t_title"]. '</option>';
                        }
                        else
                        {
                            echo '<option value="' .$row["t_id"]. '">' .$row["t_title"]. '</option>';
                        }
                    }
                    else
                    {
                        echo '<option value="' .$row["t_id"]. '">' .$row["t_title"]. '</option>';
                        $topic_selected = 1;
                        $topic_id = $row["t_id"];
                    }
            }
            echo'</select>';
            //echo $topic_id;
            
            echo'<br><br>';
            //echo '<input type="submit" name="Choose_Exam" value="Submit">';
            //echo '</form>';
            
            $sql = "Select l_id, t_id, etl_id from test_db.exam_topic_level where active = 'Y' and t_id =". $topic_id;
            //echo $sql;
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {              
                echo 'select exam level:';
                echo '<select name="exam_level_options" form="ch_exam">';

                while($row = $result->fetch_assoc())
                {
                    if($level_selected == 1)
                    {
                        if($level_id == $row["l_id"])
                        {
                            echo '<option value="' .$row["l_id"]. '" selected>' .$row["l_id"]. '</option>';
                        }
                        else
                        {
                            echo '<option value="' .$row["l_id"]. '">' .$row["l_id"]. '</option>';
                        }                        
                    }
                    else
                    {
                        $level_id = $row["l_id"];
                        $level_selected = 1;
                        echo '<option value="' .$row["l_id"]. '">' .$row["l_id"]. '</option>';
                    }
                }
                echo'</select>';
                echo'<br><br>';
            }
   }

    echo '<input type="submit" name="Choose_Exam" value="Submit">';    
    echo '</form>';
?>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if(!empty($_POST["Choose_Exam"]))
        {
            $sql = "Select etl_id from test_db.exam_topic_level where t_id=" .$_POST["exam_options"]. " and l_id=". $_POST["exam_level_options"];
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                    echo '<form action="'. $_SERVER["PHP_SELF"]. '" name="exam" method="POST">';
                    //echo '<br>'. $_POST["exam_options"]. '<br>' ;//Display the name of the exams
                    $row1 = $result->fetch_assoc();
                    $sql = "Select q_id from test_db.exam_level_question where etl_id = ". $row1["etl_id"];
                    $exam_l_q = $conn->query($sql);
                    if($exam_l_q->num_rows > 0)
                    {
                        while($row2 = $exam_l_q->fetch_assoc()) {
                                $sql = "Select q_title, q_active from test_db.exam_question where q_id = '". $row2["q_id"]. "' and q_active = 'Y'";
                                //echo $sql;
                                $exam_q = $conn->query($sql);
                                if($exam_q->num_rows > 0)
                                {
                                    while($row3 = $exam_q->fetch_assoc()) {                                  
                                        echo '<br> ' . $row2["q_id"]. ' - : ' . $row3["q_title"]. ' ' . '<br>';
                                        $sql = "Select q_id, o_id, o_title, o_ans from test_db.exam_option where q_id = '". $row2["q_id"]. "'";
                                        //echo $sql;
                                        $exam_op = $conn->query($sql);
                                        if($exam_op->num_rows > 0) {
                                            while($row4 = $exam_op->fetch_assoc()) {
                                                echo '<input type="radio" name="'. $row2["q_id"]. '" value="'. $row4["o_id"]. '">';
                                                echo $row4["o_title"]. '<br>';
                                                //echo '  '. $row4["o_id"]. ' . ' . $row4["o_title"]. '<br>'; 
                                            }
                                        }
                                    }
                                }
                                //echo '</input>';
                        }
                    }
                    echo '<br><br>';
                    echo '<input type="submit" value="Submit">';
                    echo '</form>';
            }
        }
}
$conn->close(); 
?>

</div> 
</body>
</html>