<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action=""  method="GET"></form>
    <?php
    if (isset($_GET['name'])) {
        $name = $_GET['name'];
        echo "<p>Hello" . $name . "! (from PHP)</p>";
    } else {
        echo "<p>Please provide name = ... parameter in the URL</p>";
    }
    ?>
</body>

</html>