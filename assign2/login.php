<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../styles/styles.css">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {
  
  text-align: center;
	background-color: #DAAD86 ;
  
  
  border: 3px solid #ffe5ac;}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #ab5f5a;
}

.imgcontainer {


  padding-left: 25%;

  align-items: center;
  width: 50%;
  margin: 24px 0 12px 0;

}

img.avatar {

  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
  padding-right: 25%;
  padding-left: 25%;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
</head>
<body>
<div>
<?php 
	include 'header.inc';
	include 'menu.inc';
?>
</div>
<form action="login_process.php" method="post">
  <h2>Manager Login</h2>
  <div class="imgcontainer">
    <img src="../images/manage_avatar2.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" id="username" required>
    <!-- <div id="username_error">Please fill up your username</div> -->

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" id="password" required>
    <!-- <div id="pass _error">Please fill up your username</div> -->
        
    
    <!-- <a id="login" href="manage.html"></a> -->
    <button type="submit">Login</button>
  </div>


</form>

<?php 
	include 'footer.inc'
?>

</body>
</html>