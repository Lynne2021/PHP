<?php

$dbName = 'day01first';
$dbUser = 'day01first';
$dbPass = 'hD8LGkWcxF7dlwQO';
$dbHost = 'localhost:3333';
        $link = @mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
        if (mysqli_connect_error()) {
            die("Fatal error: failed to connect to MySQL - " . mysqli_connect_error());
        }
        