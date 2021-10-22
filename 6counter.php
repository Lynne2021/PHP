<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session simple demo</title>
</head>
<body>
    <?php
        session_start();
        if (!isset($_SESSION['counter'])) {
            $_SESSION['counter'] = 0;
        }
        $_SESSION['counter']++;
        $counter = $_SESSION['counter'];
        echo "<p>You have visited this script $counter time(s) in this web browser session</p>\n";
    ?>
</body>
</html>