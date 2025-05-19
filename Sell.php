<?php
    include ("config.php");
class Sell {
    public $client_id;
    public $car_id;
    public $employee_id;
    public $sale_date;

    public function __construct($client_id, $car_id, $employee_id, $sale_date) {
        $this->client_id = $client_id;
        $this->car_id = $car_id;
        $this->employee_id = $employee_id;
        $this->sale_date = $sale_date;
    }

    public function createSell($conn) {
        $checkStmt = $conn->prepare("SELECT status FROM cars WHERE id = ?");
        $checkStmt->bind_param("i", $this->car_id);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $car = $result->fetch_assoc();

        if (!$car) {
            echo "Колата не съществува.";
            return false;
        }

        if ($car['status'] === 'продадена') {
            echo "Колата вече е продадена.";
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO sales (client_id, car_id, employee_id, sale_date) VALUES (?, ?, ?, ?);");
        $stmt->bind_param("iiis", $this->client_id, $this->car_id, $this->employee_id, $this->sale_date);
        $stmt2 = $conn->prepare("UPDATE cars SET status = 'продадена' WHERE id = ?");
        $stmt2->bind_param("i", $this->car_id);

        if ($stmt->execute()) {
            $stmt2->execute();
            return true;
        }

        return false;
    }



}