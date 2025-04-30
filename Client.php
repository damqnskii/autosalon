<?php
include ("config.php");
class Client {
    private $firstName;
    private $lastName;
    private $phoneNumber;
    private $email;

    private $address;
    public function __construct($firstName, $lastName, $phoneNumber, $email, $address) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->address = $address;
    }

    public function add($conn) {
        $stmt = $conn->prepare("INSERT INTO clients (first_name, last_name, phone, email, address) 
             VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $this->firstName, $this->lastName, $this->phoneNumber, $this->email, $this->address);
        return $stmt->execute();
    }

    public function edit($conn, $id) {
        $stmt = $conn->prepare("UPDATE clients 
                SET first_name = ?, last_name = ?, phone = ?, email = ?, address = ?
                WHERE id = ?;");
        $stmt->bind_param("sssssi", $this->firstName, $this->lastName, $this->phoneNumber, $this->email, $this->address, $id);

        return $stmt->execute();
    }

    public function getClientId($conn) {
        $stmt = $conn->prepare("SELECT id FROM clients WHERE first_name = ? AND last_name = ? AND phone = ?");
        $stmt->bind_param("sss", $this->firstName, $this->lastName, $this->phoneNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['id'] : null;
    }


    public function getAddress()
    {
        return $this->address;
    }
    public function getFirstName() {
        return $this->firstName;
    }
    public function getLastName() {
        return $this->lastName;
    }
    public function getPhoneNumber() {
        return $this->phoneNumber;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
        return $this;
    }
    public function setLastName($lastName) {
        $this->lastName = $lastName;
        return $this;
    }
    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }
    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }
}
