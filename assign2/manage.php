<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Page - HelixTech</title>
    <link href="styles/styles.css" rel="stylesheet" />
</head>
<body>
  <?php
       include 'header.inc'; 
       include 'menu.inc'; 
    ?>
    <fieldset class="manager_request">
        <legend>List all EOIs</legend>
        <form id="show_all_applications" method="get" action="displayEOI.php">
            <p class="not_highlighted">
            <input class="form_action" type="submit" name="show_all_applications" value="Show All Applications">
        </form>
    </fieldset>

    

    <form method="post" action="manage1.php">
        <fieldset class ="manager-request">
          <legend>List of EOIs for a particular position (According to JRN)</legend>
          <p class="row"> <label for="ref">Reference number (3 letters, 2 numbers) </label>
            <input type="text" name="ref" id="ref" />
          </p>
          <input type="submit" value="Search" />
        </fieldset>
      </form>
    </fieldset>

    <fieldset class="manager_request">
        <legend>Get Job Applications By Name</legend>
        <form id="get_eois_given_name" method="get" action="manage1.php">
       <form method="GET" action="manage.php">
        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" id="firstName">
        <button type="submit" name="action" value="FindAccordingtoFirstName">Search</button>
        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" id="lastName">
        <button type="submit" name="action" value="FindAccordingtoLastname">Search</button>
        
<br>
<br></b>
        <label for="FirstLastName">Both:</label>
		<form id="get_eois_given_name" method="get" action="manage1.php">
        <input type="text" name="FirstLastName" id="firstlastName">
        <button type="submit" name="action" value="FindAccordingtoFirstLastname">Search</button>
   
    </form>
    </fieldset>

    
    <fieldset class="manager_request">
        <legend>Delete Applications Given Job Reference Number</legend>
        <form id="delete_eois_given_ref" method="post" action="manage1.php">
            <label for="job_reference_number">Job Reference Number</label>
            <input type="text" name="job_reference_number" id="job_reference_number" required="required" pattern="[a-zA-Z0-9]{5}" />
            <input class="form_action" type="submit" name="SearchEOI" value="Search">
            <br>
            <br>
            <input class="form_action" type="submit" name="delete_eois_given_ref" value="Delete">
        </form>
    </fieldset>

    <fieldset class="manager_request">
        <legend>Change Status Given EOI Number</legend>
        <form id="change_status_given_eoi_number" method="post" action="manage1.php">
            <label for="eoi_number">EOI</label>
            <input type="text" name="eoi_number" id="eoi_number" required="required" pattern="[0-9]*" />

            <label for="status">Status</label>
            <form id="Status Option" method="get" action="manage1">
                    <select name="statusoptions">
                        <option value="none" selected="selected">Please Choose</option>
                        <option value="Completed">Completed</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Finalised">Finalised</option>
            </select>
            <br>
            <br>
            <input type="submit" name="action" value="Change EOI Status">
        </fieldset>
    </form>
</body>

<?php
include "footer.inc"
?>
</body>