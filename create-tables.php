<?php
    include("config.php");
    $dbname = "autosalon";

    mysqli_select_db($conn, $dbname);
    $sqlPositionTable =
        "CREATE TABLE IF NOT EXISTS positions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) UNIQUE
            );";

    if ($conn->query($sqlPositionTable) === TRUE) {
        echo "Table positions created successfully \n";
    } else {
        echo "Error creating table:  " . $conn->error;
    }

    $sqlModelTable = "CREATE TABLE IF NOT EXISTS models (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) UNIQUE    
    );";

    if ($conn->query($sqlModelTable) === TRUE) {
        echo "Table models created successfully \n";
    }  else {
        echo "Error creating table:  " . $conn->error;
    }

    $sqlBrandTable = "
    CREATE TABLE IF NOT EXISTS brands (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) UNIQUE
    );";

    if ($conn->query($sqlBrandTable) === TRUE) {
        echo "Table brands created successfully \n";
    } else {
        echo "Error creating table:  " . $conn->error;
    }

    $sqlColorTable = "
    CREATE TABLE IF NOT EXISTS colors (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) UNIQUE
    );";

    if ($conn->query($sqlColorTable) === TRUE) {
        echo "Table colors created successfully \n";
    } else {
        echo "Error creating table:  " . $conn->error;
    }

    $sqlClientTable =
        "CREATE TABLE IF NOT EXISTS clients (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(100),
        last_name VARCHAR(100),
        address VARCHAR(255),
        phone VARCHAR(20),
        email VARCHAR(100) UNIQUE
        );";


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
            position_id INT,
            phone VARCHAR(20),
            FOREIGN KEY (position_id) REFERENCES positions(id)
                ON DELETE SET NULL
                ON UPDATE CASCADE
            );";



    if ($conn->query($sqlEmployeeTable) === TRUE) {
        echo "Table employees created successfully \n";
    } else {
        echo "Error creating table: employees - \n" . $conn->error;
    }

    $sqlCarsTable =
        "CREATE TABLE IF NOT EXISTS cars (
            id INT AUTO_INCREMENT PRIMARY KEY,
            brand_id INT,
            model_id INT,
            year INT,
            color_id INT,
            mileage INT,
            price DECIMAL(10,2),
            status ENUM('свободна', 'продадена') DEFAULT 'свободна',
            FOREIGN KEY (brand_id) REFERENCES brands(id)
                ON DELETE SET NULL
                ON UPDATE CASCADE,
            FOREIGN KEY (model_id) REFERENCES models(id)
                ON DELETE SET NULL
                ON UPDATE CASCADE,
            FOREIGN KEY (color_id) REFERENCES colors(id)
                ON DELETE SET NULL
                ON UPDATE CASCADE
        );";

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

    if ($conn->query($sqlSalesTable) === TRUE) {
        echo "Table sales created successfully\n";
    } else {
        echo "Error creating table: sales - \n" . $conn->error;
    }

    $conn->close();

