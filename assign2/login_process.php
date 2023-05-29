<?php
   require_once("settings.php");
   $conn = @mysqli_connect($host, $user, $pwd, $sql_db );

   if (!$conn){
    echo "<p>Database connection failure.</p>";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];


        // prepare the sql query
        $query = $conn->prepare("SELECT * FROM Manager WHERE Username=?");
        $query->bind_param("s",$username);
        $query->execute();
        $result = $query->get_result();

        // checks if user exists and verify password
        if ($result->num_rows == 1){
            $row = $result->fetch_assoc();
            if ($password == $row['Password']){
                // password is correct, set sesison variable
                $_SESSION['username'] = $username;
                header("Location: manage.html"); //redirect
            }else{
                // password is incorrect
                echo "Invalid username or password";
            }
        }else{
            // user does not exist
            echo "Invalid username or password";
        }
        $query->close();
        $conn->close();


    }







?>