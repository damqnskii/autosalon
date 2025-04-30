<?php
    include "config.php";

    $dbname = "autosalon";
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully ";
    } else {
        die ("Error creating database: " . $conn->error);
    }
