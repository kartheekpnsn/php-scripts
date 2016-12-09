<?php
try {
    $con = mysqli_connect("localhost:MYSQL_PORTNUMBER", "MYSQL_USERNAME", "MYSQL_PASSWORD", "DATABASE_NAME");
    # # Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
}
catch (exception $e) {
    die("ERROR : " . $e->getMessage());
}
?> 
