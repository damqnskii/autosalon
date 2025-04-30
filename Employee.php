<?php
include ("config.php");
class Employee
{
    private $firstName;
    private $lastName;
    private $phoneNumber;
    private $position;

    public function __construct($firstName, $lastName, $phoneNumber, $position) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->position = $position;
    }

    private function isPositionExists($conn, $position) {
        $query = $conn->prepare("SELECT * FROM positions WHERE name = ?");
        $query->bind_param("s", $position);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function add($conn) {
        if (!$this->isPositionExists($conn, $this->position)) {
            $insertPosition = $conn->prepare("INSERT INTO positions (name) VALUES (?)");
            $insertPosition->bind_param("s", $this->position);
            $insertPosition->execute();
        }
        $getPositionId = $conn->prepare("SELECT id FROM positions WHERE name = ?");
        $getPositionId->bind_param("s", $this->position);
        $getPositionId->execute();
        $positionResult = $getPositionId->get_result();

        if ($row = $positionResult->fetch_assoc()) {
            $positionId = $row['id'];
        } else {
            return false;
        }

        $insertEmployee = $conn->prepare("INSERT INTO employees (first_name, last_name, position_id, phone) 
                                      VALUES (?, ?, ?, ?)");
        $insertEmployee->bind_param("ssis", $this->firstName, $this->lastName, $positionId, $this->phoneNumber);
        return $insertEmployee->execute();
    }
    public function edit($conn, $id) {
        if (!$this->isPositionExists($conn, $this->position)) {
            $insertPosition = $conn->prepare("INSERT INTO positions (name) VALUES (?)");
            $insertPosition->bind_param("s", $this->position);
            $insertPosition->execute();
        }
        $getPositionId = $conn->prepare("SELECT id FROM positions WHERE name = ?");
        $getPositionId->bind_param("s", $this->position);
        $getPositionId->execute();
        $positionResult = $getPositionId->get_result();

        if ($row = $positionResult->fetch_assoc()) {
            $positionId = $row['id'];
        } else {
            return false;
        }

        $stmt = $conn->prepare("UPDATE employees SET first_name = ?, last_name = ?, position_id = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("ssisi", $this->firstName, $this->lastName, $positionId, $this->phoneNumber, $id);
        return $stmt->execute();
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }


    public function getLastName()
    {
        return $this->lastName;
    }


    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }


    public function getPosition()
    {
        return $this->position;
    }


    public function setPosition($position)
    {
        $this->position = $position;
    }



}