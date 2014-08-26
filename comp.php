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

        <!-- MAIN NAV -->
        <nav>
            <ul>
                <li><a href="ms1.php">MS-1</a></li>
                <li><a href="ms2.php">MS-2</a></li>
                <li><a href="ms3.php">MS-3</a></li>
                <li><a href="ms4.php">MS-4</a></li>
                <li style="font-weight:bold"><a href="comp.php">Competencies</a></li> 

    <br />
    <br />
    <br />
                <form method="post">
                    <select name="compID" value ="<?php ?>" onchange="this.form.submit()">
                            
                        <option value = "3" 
                            <?php if(isset ($_POST["compID"]) && $_POST["compID"] == "3"){echo "selected";}?> >
                        Physician as Healer</option>
                        <option value = "12"
                            <?php if(isset ($_POST["compID"]) && $_POST["compID"] == "12"){echo "selected";}?> >
                        Physician as Scientist</option>
                        <option value ="21"
                            <?php if(isset ($_POST["compID"]) && $_POST["compID"] == "21"){echo "selected";}?>>
                        Physician as Advocate</option>
                        <option value = "29"
                            <?php if(isset ($_POST["compID"]) && $_POST["compID"] == "29"){echo "selected";}?>>
                        Physician as Educator</option>
                        <option value = "38"
                            <?php if(isset ($_POST["compID"]) && $_POST["compID"] == "38"){echo "selected";}?>>
                        Physician as Colleague</option>
                        <option value ="46"
                            <?php if(isset ($_POST["compID"]) && $_POST["compID"] == "46"){echo "selected";}?>>
                        Physician as Role Model</option>
                        <option value = "54"
                            <?php if(isset ($_POST["compID"]) && $_POST["compID"] == "54"){echo "selected";}?>>
                        Physician as Life-long Learner</option>

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
$comp_id = '3';
//get posted value from form 
if(isset($_POST["compID"])){
            $comp_id = $_POST["compID"];}

//prepared statement
//einstein query "SELECT * FROM hsdb45_med_admin.course WHERE course_id = ?";

$sql = "SELECT
                C.competency_id,
                C.title,
                A.title as course_title, 
                B.body         

        FROM hsdb45_med_admin.course as A,
             hsdb4.objective as B,
             tusk.competency as C,
             einstein.course_objective_competency as D
             
        WHERE
             A.course_id = D.course_id AND
             B.objective_id = D.objective_id AND
             C.competency_id = D.competency_id AND
             C.competency_id in (SELECT sub_id FROM einstein.link_comp_sub WHERE comp_id = ?) 

        ORDER BY C.competency_id, course_title, B.body";


             /*.course_id = ? AND 
     A.course_id = D.course_id AND
     B.objective_id = D.objective_id AND
     C.competency_id = D.competency_id";*/   

     

//prepare the query
$q = $con->prepare($sql);

//bind parameter to query (index, variable, type)
$q->bindParam(1,$comp_id,PDO::PARAM_INT);

//execute the statement
$q->execute();

//start table
echo 
"<center>
<div class=\"courseTable\" >
<table border=1>
<col width=\"33.33%\" />
<col width=\"33.33%\" />
<col width=\"33.33%\" />

<tr>
<td>Competency</td>
<td>Course</td>
<td>Objective</td>
</tr>
";

/*check the subcompetency being printed so that it only prints once*/

$competency = null;

//display fetched data
while($r = $q->fetch(PDO::FETCH_ASSOC)){
	if ($r['title'] != $competency) {

        $competency = $r['title'];

    echo "<tr>";
	    echo "<td>" . $r['title'] . "</td>";
        echo "<td>" . $r['course_title'] . "</td>";
        echo "<td>" . $r['body'] . "</td>";
    echo "</tr>";

    } else {
        echo "<tr>";
            echo "<td id =\"hide\"> </td>";
            echo "<td>" . $r['course_title'] . "</td>";
            echo "<td>" . $r['body'] . "</td>";
        echo "</tr>";
    }

}
 
 //echo $x;
echo "</table>
</div>
</center>
";

?> 

</body>
</html>





