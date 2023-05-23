<!DOCTYPE html>
<html lang="en">
<head>
<title>HelixTech</title>
<link rel="stylesheet" href="../styles/styles.css">
<link rel="stylesheet" href="https://use.typekit.net/lps7arj.css">

<meta name="viewport" content="width=device-width, initial-scale=1" >
<meta charset="UTF-8">


</head>
<body class="apply">

	<?php 
			include 'header.inc'
	?>
	


<div>
 <h1>Job Application Form</h1>
	<form action="processEOI.php" method="post" novalidate="novalidate">
		<label for="job_ref_num">Job reference number:</label>
		<input type="text" id="job_ref_num" name="job_ref_num" maxlength="5" pattern="[A-Za-z0-9]{5}" required>

		<label for="first_name">First name:</label>
		<input type="text" id="first_name" name="first_name" maxlength="20" pattern="[A-Za-z]{1,20}" required>

		<label for="last_name">Last name:</label>
		<input type="text" id="last_name" name="last_name" maxlength="20" pattern="[A-Za-z]{1,20}" required>

		<label for="dob">Date of birth:</label>
		<input type="text" id="dob" name="dob" pattern="\d{1,2}/\d{1,2}/\d{4}" required>

		<fieldset>
			<legend>Gender:</legend>
			<label for="Male">Male</label>
			<input type="radio" id="gender" name="gender" value="Male">

			<label for="Female">Female</label>
			<input type="radio" id="gender" name="gender" value="Female">

			<label for="Other">Other</label>
			<input type="radio" id="gender" name="gender" value="Other">
		</fieldset>

		<label for="street_address">Street Address:</label>
		<input type="text" id="street_address" name="street_address" maxlength="40" required>

        <label for="suburb_town">Suburb/town:</label>
<input type="text" id="suburb_town" name="suburb_town" maxlength="40" required>

<label for="state">State:</label>
<select id="state" name="state" required>
<option value="" selected disabled>Select state</option>
<option value="VIC">VIC</option>
<option value="NSW">NSW</option>
<option value="QLD">QLD</option>
<option value="NT">NT</option>
<option value="WA">WA</option>
<option value="SA">SA</option>
<option value="TAS">TAS</option>
<option value="ACT">ACT</option>
</select>

<label for="postcode">Postcode:</label>
<input type="text" id="postcode" name="postcode" pattern="\d{4}" required>

<label for="email">Email address:</label>
<input type="email" id="email" name="email" required>

<label for="phone">Phone number:</label>
<input type="tel" id="phone" name="phone" pattern="[0-9\s]{8,12}" required>


<fieldset>
	<legend>Skill list:</legend>
	<label for="skill1">Project Management</label>
    <input type="checkbox" id="skill1" name="skill[]" value="">
    <label for="skill2">Front-end Development</label>
    <input type="checkbox" id="skill2" name="skill[]" value="">
    <label for="skill3">Back-end Development</label>
    <input type="checkbox" id="skill3" name="skill[]" value="">
    <label for="skill4">Object Oriented Programming</label>
    <input type="checkbox" id="skill4" name="skill[]" value="">
    <label for="comments">Other Skills </label><br>
    <textarea id="comments" name="comments" rows="4" cols="40" placeholder= "Write description of your skills here."></textarea>
</fieldset>



<input type="submit" value="Submit">

</form>
  
</div>
<?php 
    include 'footer.inc'
 ?>
</body>
</html>


