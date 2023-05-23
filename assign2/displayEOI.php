<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="utf-8" />
    <title>Ratriaving records to HTML</title>
</head>

<body>

<?php 
	 require_once("settings.php");
	 $conn = @mysqli_connect($host, $user, $pwd, $sql_db );
 		if (!$conn){
		 echo "<p>Database connection failure.</p>";
 	} else {
	 $sql_table="EOITable";

 	$query = "select EOInumber, Job_Reference_Number, First_Name, Last_Name, Date_of_birth, Gender, Street_Address, Suburb, State, PostCode, Email, Phone, Skills, Other_Skills FROM EOITable ORDER BY  EOInumber, Job_Reference_Number, First_Name, Last_Name, Date_of_birth, Gender, Street_Address, Suburb, State, PostCode, Email, Phone, Skills, Other_Skills";

 	$result = mysqli_query($conn, $query);
 
 if(!$result){
    echo "<p>Something is wrong with ", $query, "</p>";
} else {
    echo "<table border=\"1\">\n";
    echo "<tr>\n "
         ."<th scope=\"col\">EOInumber</th>\n"
         ."<th scope=\"col\">Job_Reference_Number</th>\n"  
         ."<th scope=\"col\">First_Name</th>\n"
         ."<th scope=\"col\">Last_Name</th>\n"
         ."<th scope=\"col\">Date_of_birth</th>\n"
         ."<th scope=\"col\">Street_Address</th>\n"
         ."<th scope=\"col\">Suburb</th>\n"
         ."<th scope=\"col\">State</th>\n"
         ."<th scope=\"col\">PostCode</th>\n"
         ."<th scope=\"col\">Email</th>\n"
         ."<th scope=\"col\">Phone</th>\n"
         ."<th scope=\"col\">Skills</th>\n"
         ."<th scope=\"col\">Other_Skills</th>\n"
         ."</tr>\n";   
         
         while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>\n";
            echo "<td>", $row["EOInumber"], "</td>\n";
            echo "<td>", $row["Job_Reference_Number"], "</td>\n";
            echo "<td>", $row["First_Name"], "</td>\n";
            echo "<td>", $row["Last_Name"], "</td>\n";
            echo "<td>", $row["Date_of_birth"], "</td>\n";
            echo "<td>", $row["Street_Address"], "</td>\n";
            echo "<td>", $row["Suburb"], "</td>\n";
            echo "<td>", $row["State"], "</td>\n";
            echo "<td>", $row["PostCode"], "</td>\n";
            echo "<td>", $row["Email"], "</td>\n";
            echo "<td>", $row["Phone"], "</td>\n";
            echo "<td>", $row["Skills"], "</td>\n";
            echo "<td>", $row["Other_Skills"], "</td>\n";
            echo "</th>\n";
         }
         echo "</table>\n";

         mysqli_free_result($result);
}
mysqli_close($conn);
}
	?>



</body>
</html>