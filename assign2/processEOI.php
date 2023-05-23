<body>
    
<?php
require_once("settings.php");
$conn = @mysqli_connect($host, $user, $pwd, $sql_db );
if (!$conn) {
    echo "<p>Database connection failure.</p>";
} else {
    $sql_table="EOITable";
    $Job_Reference_Number= trim($_POST["job_ref_num"]);
    $First_Name = trim($_POST["first_name"]);
    $Last_Name= trim($_POST["last_name"]);
    $Date_of_birth= trim($_POST["dob"]);
    $Gender= trim($_POST["gender"]);
    $Street_Address= trim($_POST["street_address"]);
    $Suburb= trim($_POST["suburb_town"]);
    $State= trim($_POST["state"]);
    $PostCode= trim($_POST["postcode"]);
    $Email= trim($_POST["email"]);
    $Phone= trim($_POST["phone"]);
    $Other_Skills= trim($_POST["comments"]);
    $Skills = "";
    
    if(isset($_POST['skill1'])){
        $Skills = "Project Management";
    }
    else if(isset($_POST['skill2'])){
        $Skills = "Front-end Development";
    }
    else if(isset($_POST['skill3'])){
        $Skills = "Back-end Development";
    }
     else {
        $Skills = "Object Oriented Programming";
    }


    $query = "insert into $sql_table(Job_Reference_Number, First_Name, Last_Name, Date_of_birth, Gender, Street_Address, Suburb, State, PostCode, Email, Phone, Skills, Other_Skills) values ('$Job_Reference_Number','$First_Name','$Last_Name','$Date_of_birth','$Gender','$Street_Address','$Suburb','$State','$PostCode','$Email','$Phone','$Skills','$Other_Skills')";
    // execute the query
        $result = mysqli_query($conn, $query);
        if (!$result) {
            echo "<p class = \"wrong\" >Something is wrong with ", $query, "</p>";
            // would not show in production script
        }else{
            // diplay an operation successful message
           
            echo "<table border=\"1\">\n";
    		echo "<tr>\n "
            ."<th scope=\"col\">#</th>\n"
            ."<th scope=\"col\">Form Variable 'name'</th>\n"
            ."<th scope=\"col\">Submitted 'value'</th>\n"
            ."</tr>\n"; 
            echo "<tr>\n "
            ."<td scope=\"col\">1</td>\n"
            ."<td scope=\"col\">Job_Reference_Number</td>\n"  
            ."<td>", $Job_Reference_Number, "</td>\n"
            ."</tr>\n"; 
            echo "<tr>\n "
            ."<td scope=\"col\">2</td>\n"
            ."<td scope=\"col\">First_Name</td>\n" 
            ."<td>", $First_Name, "</td>\n"
            ."</tr>\n"; 
            echo "<tr>\n "
            ."<td scope=\"col\">3</td>\n"
            ."<td scope=\"col\">Last_Name</td>\n"
            ."<td>",  $Last_Name, "</td>\n"
            ."</tr>\n"; 
            echo "<tr>\n "
            ."<td scope=\"col\">4</td>\n"
            ."<td scope=\"col\">Date_of_birth</td>\n"
            ."<td>", $Date_of_birth, "</td>\n"
            ."</tr>\n"; 
            echo"<tr>\n "
            ."<td scope=\"col\">5</td>\n"
            ."<td scope=\"col\">Gender</td>\n"
            ."<td>", $Gender, "</td>\n"
            ."</tr>\n"; 
            echo"<tr>\n "
            ."<td scope=\"col\">6</td>\n"
            ."<td scope=\"col\">Street_Address</td>\n"
            ."<td>", $Street_Address, "</td>\n"
            ."</tr>\n"; 
            echo "<tr>\n "
            ."<td scope=\"col\">7</td>\n"
            ."<td scope=\"col\">Suburb</td>\n"
            ."<td>", $Suburb, "</td>\n"
            ."</tr>\n"; 
            echo "<tr>\n "
            ."<td scope=\"col\">8</td>\n"
            ."<td scope=\"col\">State</td>\n"
            ."<td>", $State, "</td>\n"
            ."</tr>\n"; 
            echo "<tr>\n "
            ."<td scope=\"col\">9</td>\n"
            ."<td scope=\"col\">PostCode</td>\n"
            ."<td>", $PostCode, "</td>\n"
            ."</tr>\n"; 
            echo "<tr>\n "
            ."<td scope=\"col\">10</td>\n"
            ."<td scope=\"col\">Email</td>\n"
            ."<td>", $Email, "</td>\n"
            ."</tr>\n"; 
            echo "<tr>\n "
            ."<td scope=\"col\">11</td>\n"
            ."<td scope=\"col\">Phone</td>\n"
            ."<td>", $Phone, "</td>\n"
            ."</tr>\n"; 
            echo "<tr>\n "
            ."<td scope=\"col\">12</td>\n"
            ."<td scope=\"col\">Skills</td>\n"
            ."<td>", $Skills, "</td>\n"
            ."</tr>\n"; 
            echo "<tr>\n "
            ."<td scope=\"col\">13</td>\n"
            ."<td scope=\"col\">Other_Skills</td>\n"
            ."<td>", $Other_Skills, "</td>\n"
            ."</tr>\n"; 

         echo "</table>\n";
	echo"<p>Are all name value pairs here? Anything missing?</p>";
	echo '<a href="apply.php"><button>Back</button></a>';
            } // if successfull query operation 

	
        // close the connection
        mysqli_close($conn);
}
?>
</body>