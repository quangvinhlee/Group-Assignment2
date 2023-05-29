<?php
 require_once("settings.php");
 $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

if (!$conn) {
    echo"<p>Database conn failure.</p>";
   } else {
// Function to sanitize user input
    function sanitize_input($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

// Query: List all EOITables working
    function listAllEOITables($conn)
    {
        global $conn;
        $sql_table="EOITableTable";

        $query = "select EOITablenumber, Job_Reference_Number, First_Name, Last_Name, Date_of_birth, Gender, Street_Address, Suburb, State, PostCode, Email, Phone, Skills, Other_Skills FROM EOITableTable ORDER BY  EOITablenumber, Job_Reference_Number, First_Name, Last_Name, Date_of_birth, Gender, Street_Address, Suburb, State, PostCode, Email, Phone, Skills, Other_Skills";

        $result = mysqli_query($conn, $query);

        if(!$result){
        echo "<p>Something is wrong with ", $query, "</p>";
        } else {
        include 'displayEOITable.php';
        }    

        mysqli_close($conn);
    }
    


// Query: List According to First Name and Last Name
    function getAllApplications() {
        global $conn;
        $sortRequest = sanitise_input($_GET["ref"]);

        if ($sortRequest === "none") {
            $query = "SELECT * FROM EOITable";
        } else {
            $query = "SELECT First_Name, Last_Name FROM EOITable ORDER BY Job_Reference_Number";
            
            if ($sortRequest === "FirstName") {
                $query .= "First_Name, Last_Name";
            } else if ($sortRequest === "LastName") {
                $query .= "Last_Name, First_Name";
            } else {
                $query .= $sortRequest;
            }
        }
    }
    function getApplicationFNandLN() {
        global $conn;
        $query = "SELECT First_Name, Last_Name FROM EOITable ORDER BY ";
        $result = mysqli_query($conn, $query);
    
    
    $sortRequest = sanitise_input($_GET["First_Name"]);


    if ($sortRequest === "none") {
        $query = "SELECT * FROM EOITableTable";
    } else {
        if ($sortRequest === "Both") {
            $query = "SELECT CONCAT(First_Name, ' EOITableTable', Last_Name) AS full_name FROM EOITable ORDER BY full_name";
        } else {
            $query = "SELECT First_Name, Last_Name FROM  ORDER BY ";
            
            if ($sortRequest === "FirstName") {
                $query .= "First_Name, Last_Name";
            } else if ($sortRequest === "LastName") {
                $query .= "Last_Name, First_Name";
            } else {
                $query .= $sortRequest;
            }
        }
    }

    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) === 0) {
        echo "<p>There are no job applications yet.</p>";
    } else {
        echo "<h3>List EOITables:</h3>";
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        
        if ($sortRequest === "Both") {
            echo "<th>Full Name</th>";
        } else {
            echo "<th>First Name</th>";
            echo "<th>Last Name</th>";
        }
        
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            
            if ($sortRequest === "Both") {
                echo "<td>" . $row["full_name"] . "</td>";
            } else {
                echo "<td>" . $row["First_Name"] . "</td>";
                echo "<td>" . $row["Last_Name"] . "</td>";
            }
            
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }

    mysqli_close($conn);
}

// Query: List According to JRN

           
function ListEOITablestoJRN() {
    global $conn;
    $jobReferenceNumber = sanitise_input($_POST["ref"]);
    $sortRequest = sanitise_input($_GET["manager_data"]);

    // Construct the base query
    $query = "SELECT * FROM EOITable WHERE JobReferenceNumber = '$jobReferenceNumber'";

    // Check if sorting is requested
    if ($sortRequest !== "none") {
        $query .= " ORDER BY ";

        // Add sort request
        if ($sortRequest === "FirstName") {
            $query .= "FirstName, LastName";
        } elseif ($sortRequest === "LastName") {
            $query .= "LastName, FirstName";
        } elseif ($sortRequest === "Both") {
            $query .= "CONCAT(FirstName, ' ', LastName)";
        }
    echo "<h2>EOITables with Job Reference Number:", $jobReferenceNumber, "</h2>" ;

    }

    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) === 0) {
        echo "<p>No Job Applications submitted under these/this name(s)</p>.</p>";
    } else {
        echo "<h3>List EOITables:</h3>";
        echo "<table>";
        echo "<thead>";
        echo "<tr>";

        // Check if sort request is for both first name and last name
        if ($sortRequest === "Both") {
            echo "<th>Full Name</th>";
        } else {
            echo "<th>First Name</th>";
            echo "<th>Last Name</th>";
        }

        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";

            // Display appropriate columns based on sort request
            if ($sortRequest === "Both") {
                echo "<td>" . $row["FirstName"] . " " . $row["LastName"] . "</td>";
            } else {
                echo "<td>" . $row["FirstName"] . "</td>";
                echo "<td>" . $row["LastName"] . "</td>";
            }

            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }

    mysqli_close($conn);
}

        }

    // Query: Delete EOITable according to JRN
    
if (isset($_POST["delete_EOITables_given_ref"])) {
    global $conn;
    $jobReferenceNumber = sanitise_input($_POST["reference_number"]);

    // Delete all EOITables corresponding to the entered job reference number
    $query = "DELETE FROM EOITable WHERE JobReferenceNumber = '$jobReferenceNumber'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "EOITables deleted successfully.";
    } else {
        echo "Error deleting EOITables, please make sure job position exists: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

if (isset($_POST["action"]) && $_POST["action"] === "Change EOITable Status") {
    global $conn;
    $EOITableId = sanitise_input($_POST["EOITable_id"]);
    $newStatus = sanitise_input($_POST["new_status"]);

    // Check if the new status is one of the allowed options
    $allowedStatuses = ["Completed", "In Progress", "Finalised"];
    if (!in_array($newStatus, $allowedStatuses)) {
        echo "Invalid status option.";
        return;
    }

    // Updates the EOITable status
    $query = "UPDATE EOITable SET Status = '$newStatus' WHERE EOITableId = '$EOITableId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "EOITable status updated successfully.";
    } else {
        echo "Error updating EOITable status: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
   ?>