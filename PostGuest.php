<!doctype html>

<!--
    
    Project 02.06.01
    
    Author: Abraham Aguilar
    Date: 10.24.18
    
    PostGuest.php
    
-->

<html>

<head>
    <title>Register as Guest</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <?php
    //the variable declarations below and globals are necessary for the form to function properly
    $userName = "";
    $name = "";
    $email = "";
    
    if (isset($_POST['submit'])) {
        global $userName;
        global $name;
        global $email;
        $userName = stripslashes($_POST['userName']);
        $name = stripslashes($_POST['name']);
        $email = stripslashes($_POST['email']);
        $userName = str_replace("~", "-", $userName);
        $name = str_replace("~", "-", $name);
        $email = str_replace("~", "-", $email);
        $existingUsers = array();
        //if the file exists, check for duplicate subjects
        if (file_exists("Guests.txt") && filesize("Guests.txt") > 0) {
            $usersArray = file("Guests.txt");
            $count = count($usersArray);
            for ($i = 0; $i < $count; $i++) {
                $currUser = explode("~", $usersArray[$i]);
                $existingUsers[] = $currUser[0];
            }
            if (in_array($userName, $existingUsers)) {
                echo "<p>The username <em>\"$userName\"</em> you entered already exists!<br>\n";
                echo "Please enter a new username and try again.<br>\n";
                echo "You were not registered.</p>";
                $userName = "";
            } else {
                $usersRecord = "$userName~$name~$email\n";
                $fileHandle = fopen("Guests.txt", "ab");
                
                if (!$fileHandle) {
                    echo "There was an error registering you!\n";
                } else {
                    fwrite($fileHandle, $usersRecord);
                    fclose($fileHandle);
                    echo "You have been registered.\n";
                    $userName = "";
                    $name = "";
                    $email = "";
                }
            }
        }
        else {
            $usersRecord = "$userName~$name~$email\n";
            $fileHandle = fopen("Guests.txt", "ab");
            
            if (!$fileHandle) {
                echo "There was an error registering you!\n";
            } else {
                fwrite($fileHandle, $usersRecord);
                fclose($fileHandle);
                echo "You have been registered.\n";
                $userName = "";
                $name = "";
                $email = "";
            }
        }
    }
    
    ?>
    <!-- HTML form -->
    <h1>Register as a Guest</h1>
    <hr>
    <form action="PostGuest.php" method="post">
        <span style="font-weight: bold;">User Name: <input type="text" name="userName" value="<?php echo $userName; ?>"></span>
        <span style="font-weight: bold;">Name: <input type="text" name="name" value="<?php echo $name; ?>"></span><br>
        <span style="font-weight: bold;">E-mail: <input type="text" name="email" value="<?php echo $email; ?>"></span><br>
        <input type="reset" name="reset" value="Reset Form">&nbsp;&nbsp;
        <input type="submit" name="submit" value="Register">
    </form>
    <hr>
    <p>
        <a href="GuestBook.php">View Registered Users</a>
    </p>
</body>

</html>
