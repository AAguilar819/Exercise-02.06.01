<!doctype html>

<!--
    
    Exercise 02.06.01
    
    Author: Abraham Aguilar
    Date: 10.19.18
    
    MessageBoard.php
    
-->

<html>

<head>
    <title>Message Board</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
</head>

<body>
    <!-- HTML form -->
    <h1>Message Board</h1>
    <?php
    
    $keyMessageArray = array();
    
    if (isset($_GET['action'])) {
        //checks for if a get message was sent
        if (file_exists("messages.txt") && filesize("messages.txt") != 0) {
            $messageArray = array();
            $messageArray = file("messages.txt");
            switch ($_GET['action']) {
                    //performs an action based on what was given
                case 'Delete First':
                    array_shift($messageArray);
                    break;
                case 'Delete Last':
                    array_pop($messageArray);
                    break;
                case 'Sort Ascending':
                    sort($messageArray);
                    break;
                case 'Sort Descending':
                    rsort($messageArray);
                    break;
                case 'Delete Message':
                    array_splice($messageArray, $_GET['message'], 1); // (does the job properly, but is not often used)
                    break;
                case 'Remove Duplicates':
                    $messageArray = array_unique($messageArray);
                    $messageArray = array_values($messageArray);
                    break;
            }
            if (count($messageArray) > 0) {
                //sets the file to the array that was edited earlier
                $newMessages = implode($messageArray);
                $fileHandle = fopen("messages.txt", "wb");
                if (!$fileHandle) {
                    echo "There was an error updating the message file.\n";
                } else {
                    fwrite($fileHandle, $newMessages);
                    fclose($fileHandle);
                }
            } else {
                //if nothing remains, the file is erased
                unlink("messages.txt");
            }
        }
    }
    if (!file_exists("messages.txt") || filesize("messages.txt") == 0) {
        echo "<p>There are no messages posted</p>";
    } else {
        /* To use debug:
            echo "<pre>\n";
            print_r();
            echo "</pre>\n";
        */
        //writes the messages in a table to the user
        $messageArray = file("messages.txt");
        echo "<table style=\"background-color: lightgray;\" border=\"1\" width=\"100%\">\n";
        $count = count($messageArray);
        //the for loop below changes the indexed array to an associative one, using the subject as the name for each string.
        for ($i = 0; $i < $count; $i++) {
            $currMsg = explode("~", $messageArray[$i]);
            global $keyMessageArray;
            $keyMessageArray[$currMsg[0]] = $currMsg[1] . "~" . $currMsg[2];
        }
        
        $index = 1;
        //the key function returns where the pointer is within the array.
        $key = key($keyMessageArray);
        
        //this loops through $keyMessageArray to display each piece of information, position, and the option to delete, all within a table.
        foreach ($keyMessageArray as $message) {
            $currMsg = explode("~", $message);
            echo "<tr>\n";
            echo "<td width=\"5%\" style=\"text-align: center; font-weight: bold;\">" . $index . "</td>\n";
            echo "<td width = \"85%\"><span style=\"font-weight: bold;\">Subject: </span>" . htmlentities($key) . "<br>\n";
            echo "<span style=\"font-weight: bold;\">Name: </span>" . htmlentities($currMsg[0]) . "<br>\n";
            echo "<span style=\"text-decoration: underline; font-weight: bold;\">Message: </span><br>\n" . htmlentities($currMsg[1]) . "</td>\n";
            echo "<td width=\"10%\"><a href='MessageBoard.php?" . "action=Delete%20Message" . "&message=" . ($index - 1) . "'>Delete This Message</a></td>\n";
            echo "</tr>\n";
            $index++;
            // the line below moves the pointer in $keyMessageArray and re-locates the pointer's position
            next($keyMessageArray);
            $key = key($keyMessageArray);
        }
        echo "</table>";
    }
    ?>
    <p>
        <a href="PostMessage.php">Post New Message</a><br>
        <a href="MessageBoard.php?action=Sort%20Ascending">Sort Subject A-Z</a><br>
        <a href="MessageBoard.php?action=Sort%20Descending">Sort Subject Z-A</a><br>
        <a href="MessageBoard.php?action=Delete%20First">Delete First Message</a><br>
        <a href="MessageBoard.php?action=Delete%20Last">Delete Last Message</a><br>
        <!--        <a href="MessageBoard.php?action=Remove%20Duplicates">Remove Duplicates</a><br>-->
    </p>
</body>

</html>
