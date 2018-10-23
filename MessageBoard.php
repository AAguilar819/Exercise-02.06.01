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
    if (isset($_GET['action'])) {
        //checks for if a get message was sent
        if (file_exists("messages.txt") && filesize("messages.txt") != 0) {
            $messageArray = file("messages.txt");
            switch ($_GET['action']) {
                    //performs an action based on what was given
                case 'Delete First':
                    array_shift($messageArray);
                    break;
                case 'Delete Last':
                    array_pop($messageArray);
                    break;
                case 'Delete Message':
                    array_splice($messageArray, $_GET['message'], 1); // (does the job properly, but is not often used)
                    /* $index = $_GET['message'];
                    unset($messageArray[$index]);
                    array_values($messageArray); // (required to ensure that unset works) */
                    echo "<pre>\n";
                    print_r($messageArray);
                    echo "</pre>\n";
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
        for ($i = 0; $i < $count; $i++) {
            $currMsg = explode("~", $messageArray[$i]);
            echo "<tr>\n";
            echo "<td width=\"5%\" style=\"text-align: center; font-weight: bold;\">" . ($i + 1) . "</td>\n";
            echo "<td width = \"85%\"><span style=\"font-weight: bold;\">Subject: </span>" . htmlentities($currMsg[0]) . "<br>\n";
            echo "<span style=\"font-weight: bold;\">Name: </span>" . htmlentities($currMsg[1]) . "<br>\n";
            echo "<span style=\"text-decoration: underline; font-weight: bold;\">Message: </span><br>\n" . htmlentities($currMsg[2]) . "</td>\n";
            echo "<td width=\"10%\"><a href='MessageBoard.php?" . "action=Delete%20Message" . "&message=$i'>Delete This Message</a></td>\n";
            echo "</tr>\n";
        }
        echo "</table>";
    }
    ?>
    <p>
        <a href="PostMessage.php">Post New Message</a><br>
        <a href="MessageBoard.php?action=Delete%20First">Delete First Message</a><br>
        <a href="MessageBoard.php?action=Delete%20Last">Delete Last Message</a><br>
    </p>
</body>

</html>
