<!DOCTYPE html>
<head>
<title> PHP PDO einsteining Arena! </title>
<link rel="stylesheet"  type ="text/css" href="css/style.css">
<link rel="stylesheet"  type ="text/css" href="css/tableStyle.css">
</head>

<body>

<main>
    <div id="logo">
            <a href="index.php"><img src="img/logo.jpg" /></a>
    </div>
<center>
    <header>

        <!--LOGO -->
        <!--<div id="logo">
            <img src="img/logo.jpg" />
        </div>  -->

        <!-- MAIN NAV -->
        <nav>
            <ul>
                <li><a href="ms1.php">MS-1</a></li>
                <li style="font-weight:bold"><a href="ms2.php">MS-2</a></li>
                <li><a href="ms3.php">MS-3</a></li>
                <li><a href="ms4.php">MS-4</a></li>
                <li><a href="comp.php">Competencies</a></li> 

    <br />
    <br />
    <br />
    <form method="post">
	   <select name="courseID" value ="<?php ?>" onchange="this.form.submit()" >
                            
                        <option value = "215" id="firstCourse" 
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "215"){echo "selected";}?> >
                        Endocrine</option>
                        <option value = "228"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "228"){echo "selected";}?> >
                        Nervous System and Human Behavior</option>
                        <option value ="236"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "236"){echo "selected";}?>>
                        Biomedical Ethics 2</option>
                        <option value = "243"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "243"){echo "selected";}?>>
                        EPHEM 2</option>
                        <option value = "216"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "216"){echo "selected";}?>>
                        Reproductive Systems and Human Sexuality</option>
                        <option value ="232"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "232"){echo "selected";}?>>
                        ICM: Clinical Examination</option>
                        <option value = "217"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "217"){echo "selected";}?>>
                        Cardiovascular System</option>
                        <option value = "218"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "218"){echo "selected";}?>>
                        Pulmonary System</option>
                        <option value ="219"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "219"){echo "selected";}?>>
                        Micro/Infectious Diseases</option>
                        <option value = "221"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "221"){echo "selected";}?>>
                        GI/Liver System</option>
                        <option value = "220"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "220"){echo "selected";}?>>
                        Parasitology and Global Medicine</option>
                        <option value = "225"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "225"){echo "selected";}?>>
                        Musculoskeletal Disorders</option>
                        <option value = "222"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "222"){echo "selected";}?>>
                        Hematological System</option>
                    </select>
                </form>
            </ul>
        </nav>
    </header>
</center>

<?php

//connection
//REDACTED

try {
	$con= new PDO("mysql:host=$dbhost", $dbuser, $dbpass, array(PDO::ATTR_EMULATE_PREPARES=> false,
																			   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

//catch errors
catch(PDOException $e){
	echo $e->getMEssage();
}

//first course in drop down
$course_id = "215";
//get posted value from form 
if(isset($_POST["courseID"])){
            $course_id = $_POST["courseID"];
            }
//prepared statement
//einstein query "SELECT * FROM hsdb45_med_admin.course WHERE course_id = ?";

$sql = "SELECT A.title as course_title, B.body, C.title

FROM hsdb45_med_admin.course as A,
     hsdb4.objective as B,
     tusk.competency as C,
     einstein.course_objective_competency as D
WHERE
     A.course_id = ? AND 
     A.course_id = D.course_id AND
     B.objective_id = D.objective_id AND
     C.competency_id = D.competency_id";

//prepare the query
$q = $con->prepare($sql);

//bind parameter to query (index, variable, type)
$q->bindParam(1,$course_id,PDO::PARAM_INT);

//execute the statement
$q->execute();

//start table
echo 
"<center>
<div class=\"courseTable\" >
<table border=1>
<col width=\"50%\" />
<col width=\"50%\" />
<tr>
<td>Objective</td>
<td>Competency</td>
</tr>
";



/*print the table & duplicate objective check - 
one objective can be linked to multiple competencies 
but we only want to print the objective once*/

$objective = null;

while($r = $q->fetch(PDO::FETCH_ASSOC)){
    //if the objective is not the same 
    if ($r['body'] != $objective) {

    //set objective variable to current objective body text
    $objective = $r['body'];

        echo "<tr>";
            echo "<td>" . $r['body'] . "</td>";
            echo "<td>" . $r['title'] . "</td>";
        echo "</tr>"; 

    } else {
        echo "<tr>";
            echo "<td id=\"hide\"> </td>";
            echo "<td>" . $r['title'] . "</td>";
        echo "</tr>"; 
    };
    
    //$x=$r['course_title'];
}
 
 //echo $x;
echo "</table>
</div>
</center>
";




?> 




</body>
</html>



 
<!--SELECT A.title, B.body, C.title

FROM hsdb45_med_admin.course as A,
     hsdb4.objective as B,
     tusk.competency as C,
     einstein.course_objective_competency as D
WHERE
     A.course_id = ? AND 
     A.course_id = D.course_id AND
     B.objective_id = D.objective_id AND
     C.competency_id = D.competency_id-->

