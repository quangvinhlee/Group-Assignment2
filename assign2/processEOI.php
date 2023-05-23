<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Redirect to the appropriate page or display an error message
    header("Location: index.php");
    exit();
}

// Define the sanitizeInput function
function sanitizeInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}
 
require_once("settings.php");
$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
if (!$conn) {
    echo "<p>Database connection failure.</p>";
} else {
    $sql_table = "EOITable";
    $Job_Reference_Number = trim($_POST["job_ref_num"]);
    $First_Name = trim($_POST["first_name"]);
    $Last_Name = trim($_POST["last_name"]);
    $Date_of_birth = trim($_POST["dob"]);
    $Gender = trim($_POST["gender"]);
    $Street_Address = trim($_POST["street_address"]);
    $Suburb = trim($_POST["suburb_town"]);
    $State = trim($_POST["state"]);
    $PostCode = trim($_POST["postcode"]);
    $Email = trim($_POST["email"]);
    $Phone = trim($_POST["phone"]);
    $Other_Skills = trim($_POST['other_skills']);
    $errors = [];
    $Skills = '';

    // Sanitize input
    $Job_Reference_Number = sanitizeInput($Job_Reference_Number);
    $First_Name = sanitizeInput($First_Name);
    $Last_Name = sanitizeInput($Last_Name);
    $Date_of_birth = sanitizeInput($Date_of_birth);
    $Gender = sanitizeInput($Gender);
    $Street_Address = sanitizeInput($Street_Address);
    $Suburb = sanitizeInput($Suburb);
    $State = sanitizeInput($State);
    $PostCode = sanitizeInput($PostCode);
    $Email = sanitizeInput($Email);
    $Phone = sanitizeInput($Phone);
    $Other_Skills = sanitizeInput($Other_Skills);

    if (isset($_POST['submit'])) {
        if (!empty($_POST['skill'])) {
            foreach ($_POST['skill'] as $checked) {
                $Skills .= sanitizeInput($checked);
            }
        }
    }    // Validate input
  if (!isset($_POST['otherskill']) && !empty($Other_Skills)) {
        $errors[] = "Please select Other Skills checkbox if You have Other Skills.";
    }
	if (isset($_POST['otherskill']) && empty($Other_Skills)) {
        $errors[] = "Please provide a description for Other Skills.";
    }


    // Validate Job Reference Number
    if (!preg_match("/^[A-Za-z0-9]{5}$/", $Job_Reference_Number)) {
        $errors[] = "Job Reference Number should be exactly 5 alphanumeric characters.";
    }

    
    // Validate First Name
    if (!preg_match("/^[A-Za-z]{1,20}$/", $First_Name)) {
        $errors[] = "First Name should be maximum 20 alpha characters.";
    }

    // Validate Last Name
    if (!preg_match("/^[A-Za-z]{1,20}$/", $Last_Name)) {
        $errors[] = "Last Name should be maximum 20 alpha characters.";
    }

    // Validate Date of Birth
    $dob_parts = explode('/', $Date_of_birth);
    if (count($dob_parts) !== 3 || !checkdate($dob_parts[1], $dob_parts[0], $dob_parts[2])) {
        $errors[] = "Please enter a valid Date of Birth in the format dd/mm/yyyy.";
    } else {
        $dob_timestamp = strtotime($dob_parts[2] . '-' . $dob_parts[1] . '-' . $dob_parts[0]);
        $age = date_diff(date_create(), date_create('@' . $dob_timestamp))->y;
        if ($age < 15 || $age > 80) {
            $errors[] = "Age should be between 15 and 80 years old.";
        }
    }

    // Validate Gender
    if (empty($Gender)) {
        $errors[] = "Please select a Gender.";
    }

    // Validate Street Address
    if (strlen($Street_Address) > 40) {
        $errors[] = "Street Address should be maximum 40 characters.";
    }

    // Validate Suburb/Town
    if (strlen($Suburb) > 40) {
        $errors[] = "Suburb/Town should be maximum 40 characters.";
    }

    // Validate State
    $valid_states = ['VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'];
    if (!in_array($State, $valid_states)) {
        $errors[] = "Please select a valid State.";
    }

    if (
        !preg_match('/^\d{4}$/', $PostCode) ||
        ($State === 'VIC' && substr($PostCode, 0, 1) !== '3') ||
        ($State === 'NSW' && substr($PostCode, 0, 1) !== '2') ||
        ($State === 'QLD' && substr($PostCode, 0, 1) !== '4') ||
        ($State === 'NT' && substr($PostCode, 0, 1) !== '0') ||
        ($State === 'WA' && substr($PostCode, 0, 1) !== '6') ||
        ($State === 'SA' && substr($PostCode, 0, 1) !== '5') ||
        ($State === 'TAS' && substr($PostCode, 0, 1) !== '7') ||
        ($State === 'ACT' && substr($PostCode, 0, 1) !== '0')
    ) {
        $errors[] = "Invalid Postcode. It should be 4 digits and match the selected state.";
    }

    // Validate Email
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid Email address.";
    }

    // Validate Phone number
    if (!preg_match("/^[0-9\s]{8,12}$/", $Phone)) {
        $errors[] = "Phone number should be 8 to 12 digits or spaces.";
    }

    if (!empty($errors)) {
        // Display validation errors
        echo "<p class=\"error\">Please fix the following errors:</p>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo '<a href="apply.php"><button>Back</button></a>';
    } else {
        // Convert the date of birth to yyyy-mm-dd format for database insertion
        $dob_parts = explode('/', $Date_of_birth);
        $dob = $dob_parts[2] . '-' . $dob_parts[1] . '-' . $dob_parts[0];
    
        // Insert the data into the database
        $query = "INSERT INTO $sql_table(Job_Reference_Number, First_Name, Last_Name, Date_of_birth, Gender, Street_Address, Suburb, State, PostCode, Email, Phone, Skills, Other_Skills) VALUES ('$Job_Reference_Number', '$First_Name', '$Last_Name', '$dob', '$Gender', '$Street_Address', '$Suburb', '$State', '$PostCode', '$Email', '$Phone', '$Skills', '$Other_Skills')";

        // Execute the query
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "<p class=\"error\">Something is wrong with the query: $query</p>";
        } else {
            // Display success message and the submitted data
	$eoiNumber = mysqli_insert_id($conn);
            echo "<p class=\"success\">Data submitted successfully:</p>";

echo "<p><em><strong>Your unique EOInumber is: $eoiNumber</strong></em></p>";
            echo "<table border=\"1\">\n";
            echo "<tr>\n<th scope=\"col\">#</th>\n<th scope=\"col\">Form Variable 'name'</th>\n<th scope=\"col\">Submitted 'value'</th>\n</tr>\n";
            echo "<tr>\n<td>1</td>\n<td>Job_Reference_Number</td>\n<td>$Job_Reference_Number</td>\n</tr>\n";
            echo "<tr>\n<td>2</td>\n<td>First_Name</td>\n<td>$First_Name</td>\n</tr>\n";
            echo "<tr>\n<td>3</td>\n<td>Last_Name</td>\n<td>$Last_Name</td>\n</tr>\n";
            echo "<tr>\n<td>4</td>\n<td>Date_of_birth</td>\n<td>$Date_of_birth</td>\n</tr>\n";
            echo "<tr>\n<td>5</td>\n<td>Gender</td>\n<td>$Gender</td>\n</tr>\n";
            echo "<tr>\n<td>6</td>\n<td>Street_Address</td>\n<td>$Street_Address</td>\n</tr>\n";
            echo "<tr>\n<td>7</td>\n<td>Suburb</td>\n<td>$Suburb</td>\n</tr>\n";
            echo "<tr>\n<td>8</td>\n<td>State</td>\n<td>$State</td>\n</tr>\n";
                echo "<tr>\n<td>9</td>\n<td>PostCode</td>\n<td>$PostCode</td>\n</tr>\n";
                echo "<tr>\n<td>10</td>\n<td>Email</td>\n<td>$Email</td>\n</tr>\n";
                echo "<tr>\n<td>11</td>\n<td>Phone</td>\n<td>$Phone</td>\n</tr>\n";
                echo "<tr>\n<td>12</td>\n<td>Skills</td>\n<td>$Skills ", "</td>\n</tr>\n";
                echo "<tr>\n<td>13</td>\n<td>Other_Skills</td>\n<td>$Other_Skills</td>\n</tr>\n";
                echo "</table>\n";
                echo "<p>Are all name value pairs here? Anything missing?</p>";
                echo '<a href="apply.php"><button>Back</button></a>';
            }
     }
    
        // Close the connection
        mysqli_close($conn);
        
}
?>
