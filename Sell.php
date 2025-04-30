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
        $stmt = $conn->prepare("INSERT INTO sales (client_id, car_id, employee_id, sale_date) VALUES (?, ?, ?, ?);");
        $stmt->bind_param("iiis", $this->client_id, $this->car_id, $this->employee_id, $this->sale_date);
        $stmt2 = $conn->prepare("UPDATE cars SET status = 'продадена' WHERE id = ?");
        $stmt2->bind_param("i", $this->car_id);
        $stmt2->execute();
        return $stmt->execute();

    }


}