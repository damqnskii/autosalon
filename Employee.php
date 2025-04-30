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

    public function add($conn) {
        $stmt = $conn->prepare("INSERT INTO employees (first_name, last_name, position, phone) 
             VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $this->firstName, $this->lastName, $this->position, $this->phoneNumber);
        return $stmt->execute();
    }
    public function edit($conn, $id) {
        $stmt = $conn->prepare("UPDATE employees SET first_name = ?, last_name = ?, position = ?, phone = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $this->firstName, $this->lastName, $this->position, $this->phoneNumber, $id);
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