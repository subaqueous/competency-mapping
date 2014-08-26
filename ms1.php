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
                <li style="font-weight:bold"><a href="ms1.php">MS-1</a></li>
                <li><a href="ms2.php">MS-2</a></li>
                <li><a href="ms3.php">MS-3</a></li>
                <li><a href="ms4.php">MS-4</a></li>
                <li><a href="comp.php">Competencies</a></li> 
                
                <!--YEAR 1 COURSES DROPDOWN
                    ***WRITE FUNCTION FOR IF STATEMENT THAT CHECKS SELECTED COURSE***
                -->
                <br />
                <br />
                <br />
                   <form method="post">
                        <select name="courseID" value ="<?php ?>" onchange="this.form.submit()">
                            
                        <option value = "210"  
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "210"){echo "selected";}?> >
                        Histology</option>
                        <option value = "211"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "211"){echo "selected";}?> >
                        MCFM</option>
                        <option value ="213"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "213"){echo "selected";}?>>
                        Anatomy</option>
                        <option value = "206"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "206"){echo "selected";}?>>
                        Biomedical Ethics 1</option>
                        <option value = "207"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "207"){echo "selected";}?>>
                        EPHEM 1</option>
                        <option value ="214"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "214"){echo "selected";}?>>
                        Disease Mechanisms</option>
                        <option value = "205"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "205"){echo "selected";}?>>
                        ICM: The Patient </option>
                        <option value = "212"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "212"){echo "selected";}?>>
                        ICM: Clinical Experience </option>
                        <option value ="209"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "209"){echo "selected";}?>>
                        Pharmacology</option>
                        <option value = "204"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "204"){echo "selected";}?>>
                        Renal</option>
                        <option value = "208"
                            <?php if(isset ($_POST["courseID"]) && $_POST["courseID"] == "208"){echo "selected";}?>>
                        CV Physiology</option>            
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
	echo $e->getMessage();
}

//first course in drop down
$course_id = '210';
//get posted value from form 
if(isset($_POST["courseID"])){
            $course_id = $_POST["courseID"];}

//prepared statement
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
//$rowSpan = 1;

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
            echo "<td id=\"repeat\"> </td>";
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

FROM hsdb45_med                                                                    _admin.course as A,
     hsdb4.objective as B,
     tusk.competency as C,
     einstein.course_objective_competency as D
WHERE
     A.course_id = ? AND 
     A.course_id = D.course_id AND
     B.objective_id = D.objective_id AND
     C.competency_id = D.competency_id-->

