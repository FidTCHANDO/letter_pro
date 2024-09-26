<?php
    $dbhost = "localhost";
    $dbpass = "";
    $dbuser = "root";
    $dbname = "mypage";

    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Function to check input
    function check_input ($field) {
        $field = trim($field);
        $field = stripslashes($field);
        $field = htmlspecialchars($field);
        return $field;
    };

    if ($conn->connect_error) {
        die("Could not connect to the database");
    } else {
        
    };
 ?>