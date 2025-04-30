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

    private function isModelExists($conn) {
        $stmt = $conn->prepare("SELECT * FROM models WHERE name = ?");
        $stmt->bind_param("s", $this->model);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $model = $conn->prepare("SELECT id FROM models WHERE name = ?");
            $model->bind_param("s", $this->model);
            $model->execute();
            $result = $model->get_result();
            return $result->fetch_assoc();
        } else {
            $stmt = $conn->prepare ("INSERT INTO models (name) VALUES (?)");
            $stmt->bind_param("s", $this->model);
            $stmt->execute();
            $model = $conn->prepare("SELECT id FROM models WHERE name = ?");
            $model->bind_param("s", $this->model);
            $model->execute();
            $result = $model->get_result();
            return $result->fetch_assoc();
        }
    }
    private function isBrandExists($conn) {
        $stmt = $conn->prepare("SELECT * FROM brands WHERE name = ?");
        $stmt->bind_param("s", $this->brand);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $brand = $conn->prepare("SELECT id FROM brands WHERE name = ?");
            $brand->bind_param("s", $this->brand);
            $brand->execute();
            $result = $brand->get_result();
            return $result->fetch_assoc();
        } else {
            $stmt = $conn->prepare ("INSERT INTO brands (name) VALUES (?)");
            $stmt->bind_param("s", $this->brand);
            $stmt->execute();
            $brand = $conn->prepare("SELECT id FROM brands WHERE name = ?");
            $brand->bind_param("s", $this->brand);
            $brand->execute();
            $result = $brand->get_result();
            return $result->fetch_assoc();
        }
    }
    private function isColorExists($conn) {
        $stmt = $conn->prepare("SELECT * FROM colors WHERE name = ?");
        $stmt->bind_param("s", $this->color);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $color = $conn->prepare("SELECT id FROM colors WHERE name = ?");
            $color->bind_param("s", $this->color);
            $color->execute();
            $result = $color->get_result();
            return $result->fetch_assoc();
        } else {
            $stmt = $conn->prepare ("INSERT INTO colors (name) VALUES (?)");
            $stmt->bind_param("s", $this->color);
            $stmt->execute();
            $color = $conn->prepare("SELECT id FROM colors WHERE name = ?");
            $color->bind_param("s", $this->color);
            $color->execute();
            $result = $color->get_result();
            return $result->fetch_assoc();
        }
    }

    public function add($conn) {
        $modelRow = $this->isModelExists($conn);
        $brandRow = $this->isBrandExists($conn);
        $colorRow = $this->isColorExists($conn);

        $modelId = $modelRow['id'];
        $brandId = $brandRow['id'];
        $colorId = $colorRow['id'];

        $stmt = $conn->prepare("INSERT INTO cars (brand_id, model_id, year, color_id, mileage, price, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?);");
        $stmt->bind_param("iiiiids", $brandId, $modelId, $this->year, $colorId, $this->mileage, $this->price, $this->status);
        return $stmt->execute();
    }

    public function edit($conn, $id) {
        $modelRow = $this->isModelExists($conn);
        $brandRow = $this->isBrandExists($conn);
        $colorRow = $this->isColorExists($conn);

        $modelId = $modelRow['id'];
        $brandId = $brandRow['id'];
        $colorId = $colorRow['id'];

        $stmt = $conn->prepare("UPDATE cars 
                SET brand_id = ?, model_id = ?, year = ?, color_id = ?, mileage = ? , price = ? , status = ?
                WHERE id = ?;");
        $stmt->bind_param("iiiiidsi", $brandId, $modelId, $this->year, $colorId, $this->mileage, $this->price, $this->status, $id);
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
