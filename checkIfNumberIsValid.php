<?php
    include ("config.php");

    function isNumberExists($number, $conn, $tableName) {
        $stmt = $conn->prepare("SELECT * FROM $tableName WHERE phone = ?");

        $stmt->bind_param("s", $number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    function isNumber10Symbols($number) {
        if (strlen($number) != 10) {
            return true;
        } else {
            return false;
        }
    }
    function isNumberExistsForEdit($number, $conn, $id, $tableName) {
        $stmt = $conn->prepare("SELECT * FROM $tableName WHERE phone = ? AND id != ?");

        $stmt->bind_param("si", $number, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
?>
