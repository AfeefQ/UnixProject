<?php
    $servername = "db";
    $username = "root";
    $password = "mypassword";
    // create connection
    $conn = mysqli_connect($servername, $username, $password);
    // check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    echo "Connected successfully";
    ?>