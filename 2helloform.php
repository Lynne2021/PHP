<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <?php
        function printForm($nameVal ="", $ageVal = "" ){
        //FixME:special chars in name?
        $nameVal = htmlentities($nameVal);
            // here=doc
            $form = <<<END
             <h3>Please provide name and age</h3>
             <form>
             Name: <input type="text"  name="name" value ="$nameVal" ><br />
             Age:<input type="number"  name ="age" value ="$ageVal"> <br>
             <input type="submit" value=" Say Hello">
             </form>
             END;
            echo $form;
        }
        if (isset($_GET["name"])) {//STATE 2 or 3 (receiving a submission)
            /*
            echo "<pre>\n";
            echo'$_Get' ."\n";
            print_r($_GET);
            var_dump($_GET);
            echo"</pre>\n";

*/
            //extrac submission data into variables
            $name =$_GET["name"];
            $age = $_GET['age'];
            //validate
            $errorList = [];
            if (strlen($name) < 2 || strlen($name) > 20) {
               $errorList [] = "Name must be 2-20 characters long";//append to array
               $name = "";//reset invalid value to empty string
            }
            if($age<1 || $age >150){
                $errorList [] = "Age must be 1-150";//append to array,same as array_push()
                $age = "" ;//reset invalid value to empty string
            
            }
            //sink or swim
            if (count(($errorList))) { // STATE 2: submission failed(errors found)
                echo"<P>Sumbission failed, errors found:</p>\n";
                echo "<ul>\n";
                foreach ($errorList as $error) {
                    echo "<li>$error</li>\n";
                }
                echo"</ul>\n";
                printForm($name ,$age);
            }else {//STATE 3 : submission successful - do what needs to be done
                echo"Hi $name,you are $age y/o. Nice to meet you.";
            }
        }else {//STATE 1: first display of the form
            printForm();
        }
        ?>


</body>

</html>