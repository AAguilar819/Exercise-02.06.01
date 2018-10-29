<!doctype html>

<!--
    
    Project 02.06.02
    
    Author: Abraham Aguilar
    Date: 10.26.18
    
    PostOrders.php
    
-->

<html>

<head>
    <title>Register as Guest</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
    <link href="Orders.css" rel="stylesheet">
</head>

<body>
    <h1>Register as a Guest</h1>
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
        $pattern = "/^[\w-]+(\.[\w-]+)*@" . "[\w-]+(\.[\w-]+)*" . "(\.[a-z]{2,})$/i";
        if ($userName === "" || $name === "" || $email === "") {
            // empty fields
            echo "<p>Please ensure that all fields are filled.<br>You were not registered</p>";
        } elseif (preg_match($pattern, $email) == 0) {
            // email is not valid
            echo "<p>A valid E-mail is required to register.<br>(You were not registred)</p>";
        } else {
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
                    echo "<p>The username <em>\"$userName\"</em> you entered already exists.<br>\n";
                    echo "Please enter a new username and try again.<br>\n";
                    echo "You were not registered.</p>";
                    $userName = "";
                } else {
                    // writes if no duplicates
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
                // writes if no file exists or file is empty.
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
    }
    
    ?>
    <!-- HTML form -->
    <hr>
    <form action="PostGuest.php" method="post">
        <table border="1" width="100%">
            <thead>
                <tr>
                    <th colspan="4">Items available for sale:</th>
                </tr>
                <tr>
                    <th>Name:</th>
                    <th>Description:</th>
                    <th>Cost:</th>
                    <th>Quantity to purchase:</th>
                    <th>Order:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="10%">
                        <p>[INSERT CONTENTS]</p>
                    </td>
                    <td>
                        <p>[INSERT CONTENTS]</p>
                    </td>
                    <td>
                        <p>[INSERT CONTENTS]</p>
                    </td>
                    <td>
                        <p><input type="number" min="0" max="5" name="quantity" value="0"></p>
                    </td>
                    <td>
                        <p><input type="checkbox" name="[INSERT CONTENTS]" value="Place in Shopping Cart">
                            Click to order</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <hr>
    <p>
        <a href="OnlineOrders.php">View Registered Users</a>
    </p>
</body>

</html>
