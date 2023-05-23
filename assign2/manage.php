<body>
    
<html>

<?php
   if (!isset($_SESSION["username"]))
    header("location: manager-sign-in.php");
 require_once("settings.php");
 $connection = @mysqli_connect($host, $user, $pwd, $sql_db) or die("<p>Database connection failure.</p>");



// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    $sql = "SELECT * FROM EOI_table";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h3>List EOIs:</h3>";
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>JRN</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Street Address</th>";
        echo "<th>Suburb</th>";
        echo "<th>State</th>";
        echo "<th>Postcode</th>";
        echo "<th>Email</th>";
        echo "<th>Phone Number</th>";
        echo "<th>Skills</th>";
        echo "<th>Other Skills</th>";
        echo "<th>Status</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["JRN"] . "</td>";
            echo "<td>" . $row["first_name"] . "</td>";
            echo "<td>" . $row["last_name"] . "</td>";
            echo "<td>" . $row["street_address"] . "</td>";
            echo "<td>" . $row["suburb"] . "</td>";
            echo "<td>" . $row["state"] . "</td>";
            echo "<td>" . $row["postcode"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["phone_number"] . "</td>";
            echo "<td>" . $row["skills"] . "</td>";
            echo "<td>" . $row["other_skills"] . "</td>";
            echo "<td>" . $row["status"] . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "No EOIs found.";
    }
}



// Query: List According to First Name and Last Name
function getAllApplications() {
    global $connection;
    $sortRequest = sanitise_input($_GET["manager_sort_request"]);

    if ($sortRequest === "none") {
        $query = "SELECT * FROM eoi";
    } else {
        $query = "SELECT first_name, last_name FROM eoi ORDER BY ";
        
        if ($sortRequest === "FirstName") {
            $query .= "first_name, last_name";
        } else if ($sortRequest === "LastName") {
            $query .= "last_name, first_name";
        } else {
            $query .= $sortRequest;
        }
    }
function getApplicationFNandLN() {
    $result = mysqli_query($connection, $query);
}
function getAllApplications() {
    global $connection;
    $sortRequest = sanitise_input($_GET["manager_sort_request"]);

    if ($sortRequest === "none") {
        $query = "SELECT * FROM eoi";
    } else {
        if ($sortRequest === "Both") {
            $query = "SELECT CONCAT(first_name, ' ', last_name) AS full_name FROM eoi ORDER BY full_name";
        } else {
            $query = "SELECT first_name, last_name FROM eoi ORDER BY ";
            
            if ($sortRequest === "FirstName") {
                $query .= "first_name, last_name";
            } else if ($sortRequest === "LastName") {
                $query .= "last_name, first_name";
            } else {
                $query .= $sortRequest;
            }
        }
    }

    $result = mysqli_query($connection, $query);

    if (!$result || mysqli_num_rows($result) === 0) {
        echo "<p>There are no job applications yet.</p>";
    } else {
        echo "<h3>List EOIs:</h3>";
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
                echo "<td>" . $row["first_name"] . "</td>";
                echo "<td>" . $row["last_name"] . "</td>";
            }
            
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }

    mysqli_close($connection);
}

// Query: List According to JRN

            echo "<h2>EOIs with Job Reference Number: $jobReferenceNumber</h2>";
           
function ListEOIstoJRN() {
    global $connection;
    $jobReferenceNumber = sanitise_input($_GET["reference_number"]);
    $sortRequest = sanitise_input($_GET["manager_data"]);

    // Construct the base query
    $query = "SELECT * FROM eoi WHERE JobReferenceNumber = '$jobReferenceNumber'";

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
    }

    $result = mysqli_query($connection, $query);

    if (!$result || mysqli_num_rows($result) === 0) {
        echo "<p>No Job Applications submitted under these/this name(s)</p>.</p>";
    } else {
        echo "<h3>List EOIs:</h3>";
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

    mysqli_close($connection);
}

        }

    // Query: Delete EOI according to JRN
    
if (isset($_POST["delete_eois_given_ref"])) {
    global $connection;
    $jobReferenceNumber = sanitise_input($_POST["reference_number"]);

    // Delete all EOIs corresponding to the entered job reference number
    $query = "DELETE FROM eoi WHERE JobReferenceNumber = '$jobReferenceNumber'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "EOIs deleted successfully.";
    } else {
        echo "Error deleting EOIs, please make sure job position exists: " . mysqli_error($connection);
    }

    mysqli_close($connection);
}

if (isset($_POST["action"]) && $_POST["action"] === "Change EOI Status") {
    global $connection;
    $eoiId = sanitise_input($_POST["eoi_id"]);
    $newStatus = sanitise_input($_POST["new_status"]);

    // Check if the new status is one of the allowed options
    $allowedStatuses = ["Completed", "In Progress", "Finalised"];
    if (!in_array($newStatus, $allowedStatuses)) {
        echo "Invalid status option.";
        return;
    }

    // Updates the EOI status
    $query = "UPDATE eoi SET Status = '$newStatus' WHERE EOIId = '$eoiId'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "EOI status updated successfully.";
    } else {
        echo "Error updating EOI status: " . mysqli_error($connection);
    }

    mysqli_close($connection);
}

   
   <?php 
   include "footer.inc"; 
   ?>   
   ?>
   

</body>
</html>
    