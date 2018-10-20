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
    if (!file_exists("messages.txt") || filesize("messages.txt") == 0) {
        echo "<p>There are no messages posted</p>";
    } else {
        $messageArray = file("messages.txt");
        echo "<table style=\"background-color: lightgray;\" border=\"1\" width=\"100%\">\n";
        $count = count($messageArray);
        for ($i = 0; $i < $count; $i++) {
            $currMsg = explode("~", $messageArray[$i]);
            echo "<tr>\n";
            echo "<td width=\"5%\" style=\"text-align: center; font-weight: bold;\">" . ($i + 1) . "</td>\n";
            echo "<td width = \"95%\"><span style=\"font-weight: bold;\">Subject: </span>" . htmlentities($currMsg[0]) . "<br>\n";
            echo "</tr>\n";
        }
        echo "</table>";
    }
    ?>
</body>

</html>
