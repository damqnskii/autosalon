<?php
    include ("config.php");
class Car {
    private $brand;
    private $model;
    private $year;
    private $color;
    private $mileage;
    private $price;
    private $status;

    public function __construct($brand, $model, $year, $color, $mileage, $price, $status) {
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
        $this->color = $color;
        $this->mileage = $mileage;
        $this->price = $price;
        $this->status = $status;
    }

    public function add($conn) {
        $stmt = $conn->prepare("INSERT INTO cars (brand, model, year, color, mileage, price, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("ssisids", $this->brand, $this->model, $this->year, $this->color, $this->mileage, $this->price, $this->status);
        return $stmt->execute();
    }

    public function edit($conn, $id) {
        $stmt = $conn->prepare("UPDATE cars 
                SET brand = ?, model = ?, year = ?, color = ?, mileage = ? , price = ? , status = ?
                WHERE id = ?;");
        $stmt->bind_param("ssisidsi", $this->brand, $this->model, $this->year, $this->color, $this->mileage, $this->price, $this->status, $id);
        return $stmt->execute();
    }

    public function getCarId($conn) {
        $stmt = $conn->prepare("SELECT id FROM cars WHERE brand = ? AND model = ? AND 'year' = ? AND color = ? AND mileage = ? AND price = ?;");
        $stmt->bind_param("ssisid", $this->brand, $this->model, $this->year, $this->color, $this->mileage, $this->price);
        return $stmt->execute();
    }

    public function getBrand()
    {
        return $this->brand;
    }


    public function setBrand($brand)
    {
        $this->brand = $brand;
    }


    public function getModel()
    {
        return $this->model;
    }


    public function setModel($model)
    {
        $this->model = $model;
    }


    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }


    public function getColor()
    {
        return $this->color;
    }


    public function setColor($color)
    {
        $this->color = $color;
    }


    public function getMileage()
    {
        return $this->mileage;
    }


    public function setMileage($mileage)
    {
        $this->mileage = $mileage;
    }


    public function getPrice()
    {
        return $this->price;
    }


    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getStatus()
    {
        return $this->status;
    }


    public function setStatus($status)
    {
        $this->status = $status;
    }

}
