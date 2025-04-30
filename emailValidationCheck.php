<?php
include "config.php";

function isEmailAlreadyExists ($conn, $email, $tableName) {
    $stmt = $conn->prepare("SELECT id FROM $tableName WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        return true;
    } else {
        return false;
    }
}
function isEmailValid ($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
function isEmailAlreadyExistsForEdit($conn, $email, $id, $tableName) {
    $stmt = $conn->prepare("SELECT id FROM $tableName WHERE email = ? AND id != ?");
    $stmt->bind_param("si", $email, $id);
    $stmt->execute();
    $stmt->store_result();

    return $stmt->num_rows > 0;
}