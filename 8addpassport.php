<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <title>Document</title>
</head>
<body>
    <div id="centeredContent">
    <?php
        require_once 'db.php';
        
        function printForm($passportNo = "") {
            $passportNo = htmlentities($passportNo); // avoid invalid html in case <>" are part of name
            $form = <<< END
                <form method="post" enctype="multipart/form-data">
                    Passport No.: <input type="text" name="passportNo" value="$passportNo"><br>
                    Photo: <input type="file" name="photo" /><br>
                    <input type="submit" name="submit" value="Add passport">
                </form>
            END;
            echo $form;            
        }

        // returns TRUE on success
        // returns a string with error message on failure
        // $newFilePath is assigned file name after upload
        function verifyUploadedPhoto(&$newFilePath, $passportNo) {
            // echo "<pre>\n\$_FILES content:\n";
            // print_r($_FILES);
            // echo "</pre>\n";
            $photo = $_FILES['photo'];
            // is there a photo being uploaded and is it okay?
            if ($photo['error'] != UPLOAD_ERR_OK) {
                return "Error uploading photo " . $photo['error'];
            }
            if ($photo['size'] > 2*1024*1024) { // 2MB
                return "File too big. 2MB max is allowed.";
            }
            $info = getimagesize($photo['tmp_name']);
            // echo "<pre>\ngetimagesize result:\n";
            // print_r($info);
            // echo "</pre>\n";
            if ($info[0] < 100 || $info[0] > 1000 || $info[1] < 100 || $info[1] > 1000) {
                return "Width and height must be within 200-1000 pixels range";
            }
            $ext = "";
            switch ($info['mime']) {
                case 'image/jpeg': $ext = "jpg"; break;
                case 'image/gif': $ext = "gif"; break;
                case 'image/png': $ext = "png"; break;
                default:
                    return "Only JPG, GIF, and PNG file types are accepted";
            }
            $newFilePath = "uploads/" . $passportNo . "." . $ext;
            return TRUE;
        }

        // submision or first show?
        if (isset($_POST['submit'])) {
            $passportNo = $_POST['passportNo'];
            $errorList = array();
            if (preg_match('/^[A-Z]{2}[0-9]{6}$/', $passportNo) != 1) {
                $errorList[] = "Passport number must be in AB123456 format";
            } // FIXME: make sure passport number does not already exist in the database
            $photoFilePath = null;
            $retval = verifyUploadedPhoto($photoFilePath, $passportNo);
            if ($retval !== TRUE) {
                $errorList []= $retval; // string with error was returned, add it to error list
            }
            // errors?
            if ($errorList) { // STATE 2: errors in submission - failed
                echo "<p>There were problems with your submission:</p>\n<ul>\n";
                foreach ($errorList as $error) {
                    echo "<li class=\"errorMessage\">$error</li>\n";
                }
                echo "</ul>\n";
                printForm($passportNo);
            } else { // STATE 3: successful submission
                // 1. move uploaded file to its desired location
                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photoFilePath)) {
                    die("Error moving the uploaded file. Action aborted.");
                }
                // 2. insert a new record with file path
                $sql = sprintf("INSERT INTO passports VALUES (NULL, '%s', '%s')",
                    mysqli_real_escape_string($link, $passportNo),
                    mysqli_real_escape_string($link, $photoFilePath));
                $result = mysqli_query($link, $sql);
                if (!$result) {
                    die("SQL Query failed: " . mysqli_error($link));
                }
                // 3. display confirmation to the user
                echo "<p>Passport successfully added</p>";
            }
        } else { // STATE 1: first show
            printForm();
        }
    ?>
    </div>
</body>
</html>