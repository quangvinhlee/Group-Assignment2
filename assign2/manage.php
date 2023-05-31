<!DOCTYPE html>
<html>
<head>
<title>Manage EOIs</title>
</head>
<link rel="stylesheet" href="../styles/styles.css">
<body>

<?php 
			include 'header.inc';
            include 'menu.inc'
	?>

<h2>Manage EOIs</h2>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);
?>">
<h3>List All EOIs</h3>
<input type="submit" name="list_all" value="List All EOIs">
<form id="show_all_applications" method="get" action="displayEOI.php">
<h3>List EOIs for a Position</h3>
<label for="job_reference_number">Job Reference Number:</label>
<input type="text" name="job_reference_number" id="job_reference_number">
<input type="submit" name="list_position" value="List EOIs">
<form id="show_all_EOI_for_position" method="get" action="manage.php">
<h3>List EOIs for an Applicant</h3>
<label for="first_name">First Name:</label>
<input type="text" name="first_name" id="first_name">
<label for="last_name">Last Name:</label>
<input type="text" name="last_name" id="last_name">
<input type="submit" name="list_applicant" value="List EOIs">
<form id="show_EOI_applicants" method="get" action="displayEOI.php">
<h3>Delete EOIs by Position</h3>
<label for="job_reference_number">Job Reference Number:</label>
<input type="text" name="job_reference_number" id="job_reference_number">
<input type="submit" name="delete_position" value="Delete EOIs">
<form id="Delete_applications" method="get" action="manage.php">
<h3>Change EOI Status</h3>
<label for="eoinumber">EOI Number:</label>
<input type="text" name="eoinumber" id="eoinumber">
<label for="new_status">New Status:</label>
<input type="text" name="new_status" id="new_status">
<input type="submit" name="change_status" value="Change Status">
<form id="change_eoi_status" method="get" action="manage.php">
</form>
</body>
</html>



<?php
require_once("settings.php");
$conn = mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    echo "<p>Database connection failure.</p>";
} else {
    // Function to sanitize user input
    function sanitize_input($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    // Query: List all EOIs
    function listAllEOIs($conn)
    {
        $query = "SELECT * FROM EOITable";
        $result = mysqli_query($conn, $query);
        if (!$result || mysqli_num_rows($result) === 0) {
            echo "<p>No EOIs found.</p>";
        } else {
            echo "<h3>List of EOIs:</h3>";
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
    }

    // Query: List EOIs for a particular position (given a job reference number)
    function listEOIsForPosition($conn, $jobReferenceNumber)
{
$jobReferenceNumber = sanitize_input($_POST['job_reference_number']);
$query = "SELECT * FROM EOITable WHERE Job_Reference_Number = '$jobReferenceNumber'";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) === 0) {
echo "<p>No EOIs found for Job Reference Number:", $jobReferenceNumber,"</p>";
} else {
echo "<h3>List of EOIs for Job Reference Number: ",$jobReferenceNumber, "</h3>";
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
}
    // Query: List EOIs for a particular applicant given their first name and last name
    function listEOIsForApplicant($conn, $firstName, $lastName)
    {
        $firstName = sanitize_input($firstName);
        $lastName = sanitize_input($lastName);
        $query = "SELECT * FROM EOITable WHERE First_Name LIKE '%$firstName%' AND Last_Name LIKE '%$lastName%'";
        $result = mysqli_query($conn, $query);
        if (!$result || mysqli_num_rows($result) === 0) {
            echo "<p>No EOIs found for Applicant: $firstName $lastName</p>";
        } else {
            echo "<h3>List of EOIs for Applicant: $firstName $lastName</h3>";
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
    }

    // Query: Delete EOIs for a particular position (given a job reference number)
    function deleteEOIsByJobReferenceNumber($conn, $jobReferenceNumber)
    {
        $jobReferenceNumber = sanitize_input($jobReferenceNumber);
        $query = "DELETE FROM EOITable WHERE Job_Reference_Number LIKE '%$jobReferenceNumber%'";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            echo "<p>Failed to delete EOIs for Job Reference Number: $jobReferenceNumber</p>";
        } else {
            echo "<p>Deleted EOIs for Job Reference Number: $jobReferenceNumber</p>";
        }
    }

    // Query: Change the status of an EOI (given the EOINumber)
    function changeEOIStatus($conn, $eoiID, $newStatus)
    {
        $eoiID = sanitize_input($eoiID);
        $newStatus = sanitize_input($newStatus);
        $query = "UPDATE EOITable SET EOInumber = '$newStatus' WHERE EOInumber LIKE '%$eoiID%'";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            echo "<p>Failed to update EOI status for EOINumber: $eoiID</p>";
        } else {
            echo "<p>Updated EOI status for EOINumber: $eoiID</p>";
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["list_all"])) {
            listAllEOIs($conn);
        } elseif (isset($_POST["list_position"])) {
            $jobReferenceNumber = $_POST["job_reference_number"];
            listEOIsForPosition($conn, $jobReferenceNumber);
        } elseif (isset($_POST["list_applicant"])) {
            $firstName = $_POST["first_name"];
            $lastName = $_POST["last_name"];
            listEOIsForApplicant($conn, $firstName, $lastName);
        } elseif (isset($_POST["delete_position"])) {
            $jobReferenceNumber = $_POST["job_reference_number"];
            deleteEOIsByJobReferenceNumber($conn, $jobReferenceNumber);
        } elseif (isset($_POST["change_status"])) {
            $eoiID = $_POST["eoinumber"];
            $newStatus = $_POST["new_status"];
            changeEOIStatus($conn, $eoiID, $newStatus);
        }
    }
    mysqli_close($conn);
}
?>
	<?php 
    include 'footer.inc'
 ?>