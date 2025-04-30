<?php
    include("config.php");
    $dbname = "autosalon";

    mysqli_select_db($conn, $dbname);

    $sqlClientTable =
        "CREATE TABLE IF NOT EXISTS clients (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(100),
        last_name VARCHAR(100),
        address VARCHAR(255),
        phone VARCHAR(20),
        email VARCHAR(100) UNIQUE
        );";
    mysqli_query($conn, $sqlClientTable);

    if ($conn->query($sqlClientTable) === TRUE) {
        echo "Table clients created successfully \n";
    } else {
        echo "Error creating table: clients - \n" . $conn->error;
    }

    $sqlEmployeeTable =
        "CREATE TABLE IF NOT EXISTS employees (
         id INT AUTO_INCREMENT PRIMARY KEY,
         first_name VARCHAR(100),
         last_name VARCHAR(100),
         position VARCHAR(100),
         phone VARCHAR(20)
        );";
    mysqli_query($conn, $sqlEmployeeTable);

    if ($conn->query($sqlEmployeeTable) === TRUE) {
        echo "Table employees created successfully \n";
    } else {
        echo "Error creating table: employees - \n" . $conn->error;
    }

    $sqlCarsTable =
        "CREATE TABLE IF NOT EXISTS cars (
        id INT AUTO_INCREMENT PRIMARY KEY,
        brand VARCHAR(100),
        model VARCHAR(100),
        year INT,
        color VARCHAR(50),
        mileage INT,
        price DECIMAL(10,2),
        status ENUM('свободна', 'продадена') DEFAULT 'свободна'
    )";
    mysqli_query($conn, $sqlCarsTable);

    if ($conn->query($sqlCarsTable) === TRUE) {
        echo "Table cars created successfully \n";
    } else {
        echo "Error creating table: cars - \n" . $conn->error;
    }

    $sqlSalesTable =
        "CREATE TABLE IF NOT EXISTS sales (
        id INT AUTO_INCREMENT PRIMARY KEY,
        client_id INT,
        car_id INT,
        employee_id INT,
        sale_date DATE,
        FOREIGN KEY (client_id) REFERENCES clients(id),
        FOREIGN KEY (car_id) REFERENCES cars(id),
        FOREIGN KEY (employee_id) REFERENCES employees(id)
    )";
    mysqli_query($conn, $sqlSalesTable);

    if ($conn->query($sqlSalesTable) === TRUE) {
        echo "Table sales created successfully\n";
    } else {
        echo "Error creating table: sales - \n" . $conn->error;
    }

    $conn->close();

