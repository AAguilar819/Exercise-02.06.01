<!doctype html>

<!--
    
    Project 02.06.01
    
    Author: Abraham Aguilar
    Date: 10.24.18
    
    GuestBook.php
    
-->

<html>

<head>
    <title>Guest Book</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <!-- HTML form -->
    <h1>Registered Guests</h1>
    <?php
    
    $keyUsersArray = array();
    
    if (isset($_GET['action'])) {
        //check if a delete action occurred
        if (file_exists("Guests.txt") && filesize("Guests.txt") != 0) {
            $usersArray = array();
            $usersArray = file("Guests.txt");
            switch ($_GET['action']) {
                    // does specific code based on what's given
                case 'Delete First':
                    array_shift($usersArray);
                    break;
                case 'Delete Last':
                    array_pop($usersArray);
                    break;
                case 'Sort Ascending':
                    sort($usersArray);
                    break;
                case 'Sort Descending':
                    rsort($usersArray);
                    break;
                case 'Delete User':
                    array_splice($usersArray, $_GET['user'], 1);
                    break;
            }
            if (count($usersArray) > 0) {
                // edits the file to remove the deleted users
                $newUsers = implode($usersArray);
                $fileHandle = fopen("Guests.txt", "wb");
                if (!$fileHandle) {
                    echo "There was an error updating the user list.\n";
                } else {
                    fwrite($fileHandle, $newUsers);
                    fclose($fileHandle);
                }
            } else {
                // if no content, erase file
                unlink("Guests.txt");
            }
        }
    }
    if (!file_exists("Guests.txt") || filesize("Guests.txt") == 0) {
        echo "<p>There are no registered users</p>";
    } else {
        // displays registered users to user via table
        $usersArray = file("Guests.txt");
        echo "<table style=\"background-color: lightgray;\" border=\"1\" width=\"100%\">\n";
        $count = count($usersArray);
        // turns indexed array into associative array
        for ($i = 0; $i < $count; $i++) {
            $currUser = explode("~", $usersArray[$i]);
            global $keyUsersArray;
            $keyUsersArray[$currUser[0]] = $currUser[1] . "~" . $currUser[2];
        }
        
        $index = 1;
        // stores where the array pointer is
        $key = key($keyUsersArray);
        
        // loop through the array to display a table
        foreach ($keyUsersArray as $user) {
            $currUser = explode("~", $user);
            echo "<tr>\n";
            echo "<td width=\"5%\" style=\"text-align: center; font-weight: bold;\">" . $index . "</td>\n";
            echo "<td width = \"85%\"><span style=\"font-weight: bold;\">Username: </span>" . htmlentities($key) . "<br>\n";
            echo "<span style=\"font-weight: bold;\">Name: </span>" . htmlentities($currUser[0]) . "<br>\n";
            echo "<span style=\"font-weight: bold;\">E-mail: </span><br>\n" . htmlentities($currUser[1]) . "</td>\n";
            echo "<td width=\"10%\"><a href='GuestBook.php?" . "action=Delete%20User" . "&user=" . ($index - 1) . "'>Delete This User</a></td>\n";
            echo "</tr>\n";
            $index++;
            // moves the pointer
            next($keyUsersArray);
            $key = key($keyUsersArray);
        }
        echo "</table>";
    }
    ?>
    <p>
        <a href="PostGuest.php">Register New User</a><br>
        <a href="GuestBook.php?action=Sort%20Ascending">Sort Users A-Z</a><br>
        <a href="GuestBook.php?action=Sort%20Descending">Sort Users Z-A</a><br>
        <a href="GuestBook.php?action=Delete%20First">Delete First User</a><br>
        <a href="GuestBook.php?action=Delete%20Last">Delete Last User</a><br>
    </p>
</body>

</html>
